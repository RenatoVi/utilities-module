<?php

namespace Modules\Utilities\Helpers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


/**
 *
 * @class ResponseAPIHelper
 *
 */
abstract class ResponseAPIHelper
{
    const SUCCESS = 'success';

    const ERROR = 'error';

    private static function sendResponse($data, $messages, $code, $type)
    {
        $response = [
            'type' => $type,
            'data' => $data,
            'message' => $messages,
        ];
        return response()->json($response, $code);
    }

    /**
     *
     * @param mixed $data
     * @param string $messages
     * @param int $code
     * @return JsonResponse
     */
    public static function sendSuccess($data, string $messages = 'Sucesso', $code = Response::HTTP_OK)
    {
        return self::sendResponse($data, $messages, $code, static::SUCCESS);
    }

    /**
     *
     * @param mixed $data
     * @param string $messages
     * @param int $code
     * @return JsonResponse
     */
    public static function sendError($data = null, $messages = 'Erro!', $code = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        if(!empty(env("APP_ENV")) && env("APP_ENV") == "production"){
            $messages = 'Erro!';
        }
        return self::sendResponse($data, $messages, $code, static::ERROR);
    }
}
