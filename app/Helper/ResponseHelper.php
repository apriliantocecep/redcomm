<?php

namespace App\Helper;

use \Illuminate\Http\JsonResponse;

class ResponseHelper implements \App\Interfaces\ResponseHelperInterface
{
    public static function error($data, $status = 200) :JsonResponse
    {
        return response()->json([
            'error' => true,
            'data' => $data,
        ], $status);
    }
    
    public static function ok($data, $status = 200) :JsonResponse
    {
        return response()->json([
            'error' => false,
            'data' => $data,
        ], $status);
    }
}