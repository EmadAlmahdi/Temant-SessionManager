<?php declare(strict_types=1);

namespace Temant\SessionManager\Exceptions {

    use Exception;
    use Throwable;

    class SessionStartedException extends Exception implements Throwable
    {
        /**
         * Constructor for SessionStartedException.
         *
         * @param string $message The error message for this exception.
         * @param int $code The error code for this exception (default: 800).
         */
        public function __construct(string $message = "Session has already been started", int $code = 800)
        {
            parent::__construct($message, $code);
        }
    }
}