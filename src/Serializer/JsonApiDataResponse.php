<?php
/*
 * Son T. Tran
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Son T. Tran license that is
 * available through the world-wide-web at this URL:
 * https://www.trants.io/LICENSE.txt
 *
 * DISCLAIMER
 *
 * @author          Son T. Tran
 * @package         trants/easy-jsonapi
 * @copyright       Copyright (c) Son T. Tran. ( https://trants.io )
 * @license         https://trants.io/LICENSE.txt
 *
 */

namespace Trants\EasyJsonApi\Serializer;

use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class JsonApiDataResponse
{
    /**
     * Define the data for the transformer.
     *
     * @var mixed
     */
    protected $data;

    /**
     * Define the name for the transformer.
     *
     * @var string
     */
    protected $name;

    /**
     * Define the manager for the transformer.
     *
     * @var \League\Fractal\Manager
     */
    protected $manager;

    /**
     * Define the transformer.
     *
     * @var \Trants\EasyJsonApi\ExtendedTransformer
     */
    protected $transformer;

    /**
     * JsonApiDataResponse constructor.
     *
     * @param mixed $data
     * @param string $name
     * @param array $includes
     * @param \Trants\EasyJsonApi\ExtendedTransformer $transformer
     */
    public function __construct($data, $name, $includes = [], $transformer)
    {
        $this->data        = $data;
        $this->name        = $name;
        $this->manager     = (new Manager())->setSerializer(new JsonApiSerializer());
        $this->transformer = $transformer;
        if ($includes) {
            $this->includes($includes);
        }
    }

    /**
     * Parse include string.
     *
     * @param array $includes
     */
    public function includes($includes)
    {
        $this->manager->parseIncludes($includes);
    }

    /**
     * Formats data as JSON response.
     *
     * @param int $status
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response($status = 200, $headers = [])
    {
        return response()->json($this->manager->createData($this->createResource())->toArray(), $status, $headers);
    }

    /**
     * Convert the current data for this scope to an array.
     *
     * @return \League\Fractal\Resource\ResourceAbstract
     */
    private function createResource()
    {
        if (is_null($this->data)) {
            return new \League\Fractal\Resource\NullResource($this->data, $this->transformer, $this->getName());
        } else {
            if ($this->data instanceof \Illuminate\Database\Eloquent\Model) {
                return new \League\Fractal\Resource\Item($this->data, $this->transformer, $this->getName());
            } else {
                if ($this->data instanceof \Illuminate\Support\Collection) {
                    return new \League\Fractal\Resource\Collection($this->data, $this->transformer, $this->getName());
                } else {
                    if (is_array($this->data)) {
                        return new \League\Fractal\Resource\Collection($this->data, $this->transformer, $this->getName());
                    } else {
                        if ($this->data instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) {
                            $collection = new \League\Fractal\Resource\Collection($this->data->getCollection(), $this->transformer, $this->getName());
                            $collection->setPaginator(new \League\Fractal\Pagination\IlluminatePaginatorAdapter($this->data));

                            return $collection;
                        } else {
                            if ($this->data instanceof \stdClass) {
                                return new \League\Fractal\Resource\Item($this->data, $this->transformer, $this->getName());
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Get the name of the transformer.
     *
     * @return mixed
     */
    protected function getName()
    {
        return $this->name ?: $this->transformer->getName();
    }
}
