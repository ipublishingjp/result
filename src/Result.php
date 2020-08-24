<?php
namespace Snscripts\Result;

use Exception;

class Result
{
    protected $success = false;
    protected $code = '';
    protected $message = '';
    protected $errors = [];
    protected $extras = [];

    /**
     * @var ?Exception
     */
    protected $exception = null;

    const
        SUCCESS = true,
        FAIL = false,

        // readable string codes to describe the result in multi lang situations
        CREATED    = 'created',
        UPDATED    = 'updated',
        SAVED      = 'saved',
        DELETED    = 'deleted',
        VALIDATION = 'validation',
        AUTH       = 'authorised',
        NOT_AUTH   = 'not_authorised',
        FOUND      = 'found',
        NOT_FOUND  = 'not_found',
        ERROR      = 'error',
        FAILED     = 'failed',
        PROCESSING = 'processing';

    /**
     * initiate a success result
     *
     * @param string $code
     * @param string $message
     * @param array $errors
     * @param array $extras
     * @return Result $Result
     */
    public static function success(string $code = '', string $message = '', array $errors = [], array $extras = [])
    {
        return self::loadResult(self::SUCCESS, $code, $message, $errors, $extras, null);
    }

    /**
     * initiate a fail result
     *
     * @param string $code
     * @param string $message
     * @param array $errors
     * @param array $extras
     * @param ?Exception $exception
     * @return Result $Result
     */
    public static function fail(string $code = '', string $message = '', array $errors = [], array $extras = [], ?Exception $exception = null)
    {
        return self::loadResult(self::FAIL, $code, $message, $errors, $extras, $exception);
    }

    /**
     * load up the result object
     *
     * @param bool $status
     * @param string $code
     * @param string $message
     * @param array $errors
     * @param array $extras
     * @param ?Exception $exception
     * @return Result $Result
     */
    protected static function loadResult(bool $status, string $code, string $message, array $errors, array $extras, ?Exception $exception)
    {
        $Result = new static($status);

        if (! empty($code)) {
            $Result->setCode($code);
        }

        if (! empty($message)) {
            $Result->setMessage($message);
        }

        if (! empty($errors)) {
            $Result->setErrors($errors);
        }

        if (! empty($extras)) {
            $Result->setExtras($extras);
        }

        if ($exception !== null) {
            $Result->setException($exception);
        }

        return $Result;
    }

    /**
     * construct the Result object with a true / false denoting successful or not
     *
     * @param $success bool
     */
    public function __construct(bool $success)
    {
        $this->success = $success;
    }

    /**
     * was the result successful
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return ($this->success === self::SUCCESS);
    }

    /**
     * did the result fail
     *
     * @return bool
     */
    public function isFail(): bool
    {
        return ($this->success === self::FAIL);
    }

    /**
     * set the code
     *
     * @param string $code
     * @return Result $this
     */
    public function setCode(string $code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * get the code
     *
     * @return string $code
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * set a more elaborate message
     *
     * @param string $message
     * @return Result $this
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * get the message
     *
     * @return string $message
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * get the error messages
     *
     * @return array $errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * set all the error messages
     *
     * @param array $errors
     * @return Result $this
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * add an error message to the list
     *
     * @param mixed $error
     * @return Result $this
     */
    public function addError($error)
    {
        if (is_array($error)) {
            $this->errors += $error;
        } else {
            $this->errors[] = $error;
        }

        return $this;
    }

    /**
     * get the extra data
     *
     * @return array $extras
     */
    public function getExtras(): array
    {
        return $this->extras;
    }

    /**
     * get individual extra items
     *
     * @param string $key
     * @return mixed
     */
    public function getExtra(string $key)
    {
        if (array_key_exists($key, $this->extras)) {
            return $this->extras[$key];
        }

        return false;
    }

    /**
     * set extra data
     *
     * @param string $key
     * @param mixed $data
     * @return Result $this
     */
    public function setExtra(string $key, $data)
    {
        $this->extras[$key] = $data;
        return $this;
    }

    /**
     * set all extra data
     *
     * @param array $extras
     * @return Result $this
     */
    public function setExtras(array $extras)
    {
        $this->extras = $extras;
        return $this;
    }

    /**
     * get the extra data
     *
     * @return ?Exception
     */
    public function getException(): ?Exception
    {
        return $this->exception;
    }

    /**
     * set exception
     *
     * @param ?Exception $exception
     * @return Result $this
     */
    public function setException($exception)
    {
        $this->exception = $exception;
        return $this;
    }
}
