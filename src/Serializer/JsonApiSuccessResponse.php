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

class JsonApiSuccessResponse
{
    /**
     * Define the message for the response.
     *
     * @var string
     */
    protected $message;

    /**
     * JsonApiSuccessResponse constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Formats success as JSON response.
     *
     * @param int $status
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response($status = 200, $headers = [])
    {
        $result = [];
        if ($this->message) {
            $result['message'] = $this->message;
        }

        return response()->json($result, $status, $headers);
    }
}
