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

namespace Trants\EasyJsonApi;

use League\Fractal\TransformerAbstract;

abstract class ExtendedTransformer extends TransformerAbstract
{
    /**
     * Define the name for the transformer.
     *
     * @var string
     */
    protected $name;

    /**
     * Define the options for the transformer.
     *
     * @var array
     */
    protected $options;

    /**
     * ExtendedTransformer constructor.
     *
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->options = $options;
    }

    /**
     * Get the name of the transformer.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value for the transformer.
     *
     * @param array $key
     * @return mixed
     */
    public function getValue($key)
    {
        return array_get($this->options, $key, null);
    }

    /**
     * Get the options for the transformer.
     *
     * @param string $key
     * @return mixed
     */
    public function getOptions($key)
    {
        return array_get($this->options, $key, []);
    }

    /**
     * Get the item resource object.
     *
     * @param mixed $data
     * @param string $resourceKey
     * @param \Trants\EasyJsonApi\ExtendedTransformer $transformer
     * @return \League\Fractal\Resource\Item
     */
    public function item($data, $resourceKey, $transformer)
    {
        return parent::item($data, $transformer, is_null($resourceKey) && !is_callable($transformer) ? $transformer->getName() : $resourceKey);
    }

    /**
     * Get the collection resource object.
     *
     * @param mixed $data
     * @param string $resourceKey
     * @param \Trants\EasyJsonApi\ExtendedTransformer $transformer
     * @return \League\Fractal\Resource\Collection
     */
    public function collection($data, $resourceKey, $transformer)
    {
        return parent::collection($data, $transformer, is_null($resourceKey) && !is_callable($transformer) ? $transformer->getName() : $resourceKey);
    }

    /**
     * The null resource represents a resource that doesn't exist.
     *
     * @return mixed
     */
    public function null()
    {
        return parent::null();
    }

    /**
     * Transformer abstract method.
     *
     * @param mixed $resource
     * @return mixed
     */
    public abstract function transform($resource);
}
