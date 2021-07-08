<?php

namespace App\Exceptions;

use Mi\Core\Exceptions\BaseException;

/**
 * @method static \Throwable invalidCredentials()
 */
class AuthException extends BaseException
{
    protected static function getPrefix()
    {
        return 'auth';
    }
}
