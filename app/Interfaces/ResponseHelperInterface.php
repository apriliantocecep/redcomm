<?php

namespace App\Interfaces;

use \Illuminate\Http\JsonResponse;

interface ResponseHelperInterface
{
    public static function error($data, $status) :JsonResponse;
    public static function ok($data, $status) :JsonResponse;
}