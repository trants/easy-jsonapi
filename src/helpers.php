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

if (!function_exists('eja_data')) {
    /**
     * Formats data as JSON response.
     *
     * @param mixed $data
     * @param string $name
     * @param int $status
     * @param array $includes
     * @param array $headers
     * @param \Trants\EasyJsonApi\ExtendedTransformer $transformer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function eja_data($data, $name = null, $status = 200, $includes = [], $headers = [], $transformer)
    {
        $response = new \Trants\EasyJsonApi\Serializer\JsonApiDataResponse($data, $name, $includes, $transformer);
        return $response->response($status, $headers);
    }
}

if (!function_exists('eja_error')) {
    /**
     * Formats error as JSON response.
     *
     * @param string $message
     * @param int $status
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function eja_error($message, $status = 400, $headers = [])
    {
        $response = new \Trants\EasyJsonApi\Serializer\JsonApiErrorResponse($message);
        return $response->response($status, $headers);
    }
}

if (!function_exists('eja_form_error')) {
    /**
     * Formats the JSON from errors response.
     *
     * @param string $message
     * @param int $status
     * @param array $headers
     * @param \Illuminate\Validation\Validator $validator
     * @return Symfony\Component\HttpFoundation\Response
     */
    function eja_form_error($message, $status = 400, $headers = [], $validator)
    {
        $response = new \Trants\EasyJsonApi\Serializer\JsonApiFormErrorResponse($message, $validator);
        return $response->response($status, $headers);
    }
}

if (!function_exists('eja_success')) {
    /**
     * Formats success as JSON response.
     *
     * @param string $message
     * @param int $status
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function eja_success($message, $status = 200, $headers = [])
    {
        $response = new \Trants\EasyJsonApi\Serializer\JsonApiSuccessResponse($message);
        return $response->response($status, $headers);
    }
}
