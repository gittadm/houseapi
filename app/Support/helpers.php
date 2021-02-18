<?php

if (!function_exists('response_ok')) {
    /**
     * For HTTP_OK
     *
     * @param array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    function response_ok(array $data = [], int $code = \Illuminate\Http\JsonResponse::HTTP_OK)
    {
        return response()->json($data, $code);
    }
}

if (!function_exists('id')) {
    /**
     * Get auth user id
     *
     * @return int|string|null
     */
    function id()
    {
        return Auth::id();
    }
}
