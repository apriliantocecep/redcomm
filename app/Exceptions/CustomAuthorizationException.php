<?php

namespace App\Exceptions;

use Exception;
use App\Helper\ResponseHelper;
use Illuminate\Auth\Access\AuthorizationException as ParentAuthorizationException;

class CustomAuthorizationException extends ParentAuthorizationException
{
    public function render($request)
    {
        return ResponseHelper::error([
            'message' => "You are not authorized to make this request."
        ], 403);
    }
}
