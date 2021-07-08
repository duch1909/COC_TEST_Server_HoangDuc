<?php

namespace Mi\Core\Exceptions;

use Exception;
use Illuminate\Support\Str;

/** @SuppressWarnings(PHPMD.NumberOfChildren) */
abstract class BaseException extends Exception
{
    /**
     * @var int
     */
    protected $code = 400;

    /**
     * @var string
     */
    protected $messageCode = null;

    /**
     * Get prefix of code
     *
     * @return string
     */
    abstract protected static function getPrefix();

    /**
     * Set the message code
     *
     * @param string $code
     * @return self
     */
    public function setMessageCode(string $code)
    {
        $this->messageCode = $code;

        return $this;
    }

    /**
     * Get the message code
     *
     * @return string
     */
    public function getMessageCode()
    {
        return $this->messageCode;
    }

    public static function __callStatic($name, $arguments)
    {
        $code = static::getPrefix() . '.' . Str::snake($name);
        
        return (new static(__('messages.' . $code, $arguments[1] ?? []), $arguments[0] ?? 0))->setMessageCode($code);
    }
}
