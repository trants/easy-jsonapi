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

use Illuminate\Validation\Validator;

class JsonApiFormErrorResponse
{
    /**
     * Define the message for the response.
     *
     * @var string
     */
    protected $message;

    /**
     * Define the validator for the response.
     *
     * @var \Illuminate\Validation\Validator
     */
    protected $validator;

    /**
     * JsonApiFormErrorResponse constructor.
     *
     * @param string $message
     * @param \Illuminate\Validation\Validator $validator
     */
    public function __construct($message, Validator $validator)
    {
        $this->message   = $message;
        $this->validator = $validator;
    }

    /**
     * Formats the JSON from errors response.
     *
     * @param int $status
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response($status = 400, array $headers = array())
    {
        $errorFields = [];
        foreach ($this->validator->getMessageBag()->getMessages() as $field => $messages) {
            $errorFields[$field] = $messages[0];
        }

        $result = [
            'error' => [
                'fields' => $errorFields,
            ]
        ];

        if ($this->message) {
            $result['error']['message'] = $this->message;
        }

        return response()->json($result, $status, $headers);
    }
}
