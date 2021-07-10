<?php

namespace App\Concerns;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * @method self tokenById($id)
 * @method self attempt($data)
 * @method self fromUser($user)
 */
class Token implements Arrayable
{
    /**
     * Default TTL is 7 days
     */
    const DEFAULT_TTL = '7 days';

    /**
     * @var string
     */
    protected $guard;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $type = 'bearer';

    /**
     * @var \Carbon\CarbonInterface
     */
    protected $expiry;

    /**
     * @var array
     */
    protected $claims = [];

    public function __construct(string $guard)
    {
        $this->guard = $guard;
        $this->expiry = $this->guessExpiryByGuard($guard);
    }

    /**
     * Make new token
     *
     * @param string $guard
     * @param string $method
     * @param mixed $data
     * @return \App\Concerns\Token
     */
    public static function make(string $guard, string $method, $data = null)
    {
        $instance = new self($guard);
        /** @var \Tymon\JWTAuth\JWTGuard */
        $guardInstance = Auth::guard($guard);
        $instance->token = $guardInstance->claims(['exp' => $instance->expiry])->$method($data);

        return $instance;
    }

    /**
     * Set claims for token
     *
     * @param array $claims
     * @return self
     */
    public function setClaims($claims)
    {
        $this->claims = array_merge($this->claims, $claims);

        return $this;
    }

    /**
     * Get generated token
     *
     * @return string|bool|null
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Check that token is exits
     *
     * @return bool
     */
    public function notExists()
    {
        return ! $this->token;
    }

    /**
     * Guess expiry by guard
     *
     * @param string $guard
     * @return \Carbon\CarbonInterface
     */
    public function guessExpiryByGuard(string $guard)
    {
        return Carbon::now()->add(config('auth.guards.' . $guard .  '.ttl') ?? self::DEFAULT_TTL);
    }

    /**
     * Return data as array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'access_token' => $this->token,
            'token_type' => $this->type,
            'expires_at' => $this->expiry->toIso8601String(),
            'jti' => $this->getJti($this->token)
        ];
    }

    /**
     * Get JTI from the token
     *
     * @param string $token
     * @return string
     */
    public function getJti(string $token)
    {
        /** @var \Tymon\JWTAuth\JWTGuard */
        $guardInstance = Auth::guard($this->guard);
        return $guardInstance->setToken($token)->getPayload()->get('jti');
    }
}
