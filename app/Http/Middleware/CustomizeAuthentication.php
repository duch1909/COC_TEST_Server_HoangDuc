<?php

namespace App\Http\Middleware;

use App\Models\CourseRegistration;
use Closure;
use Illuminate\Auth\AuthenticationException;
use App\Http\Middleware\Authenticate;

class CustomizeAuthentication extends Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if ($request->headers->has('Authorization')) {
            $this->authenticate($request, $guards);
        } else {
            $isValidToken = CourseRegistration::where([
                'token' => $request->token,
                'id' => $request->course_registration
            ])->exists();

            if (empty($request->token) || !$isValidToken) {
                throw new AuthenticationException();
            }
        }
    }
}
