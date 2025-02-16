<?php

if (!function_exists('failResponse')) {
    /**
     * Build fail response
     *
     * @param $code
     * @param $message
     * @param $error
     * 
     * @return mixed
     */
    function failResponse($code = Response::HTTP_BAD_REQUEST, $message = '', $error = [])
    {
        return response()->json([
            'success' => false,
            'error' => $error,
            'message' => $message,
            'code' => $code
        ], $code);
    }
}
