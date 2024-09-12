<?php declare(strict_types=1);

namespace Temant\SessionManager {
    use Temant\SessionManager\Exceptions\{
        SessionNotStartedException,
        SessionStartedException
    };

    class SessionManager implements SessionManagerInterface
    {
        /**
         * Checks if the session is currently active.
         *
         * @return bool True if the session is active, false otherwise.
         */
        public function isActive(): bool
        {
            return session_status() === PHP_SESSION_ACTIVE;
        }

        /**
         * Set the session name.
         *
         * @param string $name The name of the session.
         * @return static
         * @throws SessionStartedException If the session is already started.
         */
        public function setName(string $name): self
        {
            if (!$this->isActive()) {
                session_name($name);
                return $this;
            }
            throw new SessionStartedException('Cannot set session name, session already started.');
        }

        /**
         * Start a new session or resume the existing session.
         * @param array<string, mixed> $options Array of session configuration options.
         * @return bool True if the session was successfully started, false otherwise.
         * @throws SessionStartedException If the session is already started.
         */
        public function start(array $options = []): bool
        {
            return !$this->isActive()
                ? session_start($options)
                : throw new SessionStartedException('Cannot start session, session already started.');
        }

        /**
         * Set a session variable.
         *
         * @param string $key The name of the session variable.
         * @param mixed $value The value to set.
         * @return static
         * @throws SessionNotStartedException If the session is not active.
         */
        public function set(string $key, mixed $value): self
        {
            if ($this->isActive()) {
                $_SESSION[$key] = $value;
                return $this;
            }
            throw new SessionNotStartedException('Cannot set session variable, session not started.');
        }

        /**
         * Get the value of a session variable.
         *
         * @param string $key The name of the session variable.
         * @return mixed The value of the session variable, or null if it doesn't exist.
         * @throws SessionNotStartedException If the session is not active.
         */
        public function get(string $key): mixed
        {
            if ($this->isActive()) {
                return $this->has($key) ? $_SESSION[$key] : null;
            }
            throw new SessionNotStartedException('Cannot get session variable, session not started.');
        }

        /**
         * Get the value of all the session variables.
         *
         * @return array<string, mixed> The array of all session variables.
         * @throws SessionNotStartedException If the session is not active.
         */
        public function all(): array
        {
            if ($this->isActive()) {
                return $_SESSION;
            }
            throw new SessionNotStartedException('Cannot get session variables, session not started.');
        }

        /**
         * Check if a session variable exists.
         *
         * @param string $key The name of the session variable.
         * @return bool True if the session variable exists, false otherwise.
         * @throws SessionNotStartedException If the session is not active.
         */
        public function has(string $key): bool
        {
            if ($this->isActive()) {
                return isset($_SESSION[$key]);
            }
            throw new SessionNotStartedException('Cannot check session variable, session not started.');
        }

        /**
         * Remove a session variable.
         *
         * @param string $key The name of the session variable to remove.
         * @return static
         * @throws SessionNotStartedException If the session is not active.
         */
        public function remove(string $key): self
        {
            if ($this->isActive()) {
                unset($_SESSION[$key]);
                return $this;
            }
            throw new SessionNotStartedException('Cannot remove session variable, session not started.');
        }

        /**
         * Regenerate the session ID.
         *
         * @param bool $deleteOldSession Whether to delete the old session data or not.
         * @return bool True if the session ID was regenerated, false otherwise.
         * @throws SessionNotStartedException If the session is not active.
         */
        public function regenerate(bool $deleteOldSession = true): bool
        {
            if ($this->isActive()) {
                return session_regenerate_id($deleteOldSession);
            }
            throw new SessionNotStartedException('Cannot regenerate session ID, session not started.');
        }

        /**
         * Destroy the current session.
         *
         * @return bool True if the session was successfully destroyed, false otherwise.
         * @throws SessionNotStartedException If the session is not active.
         */
        public function destroy(): bool
        {
            if ($this->isActive()) {
                session_unset();
                return session_destroy();
            }
            throw new SessionNotStartedException('Cannot destroy session, session not started.');
        }

        /**
         * Save and close the session data.
         *
         * @return static
         * @throws SessionNotStartedException If the session is not active.
         */
        public function close(): self
        {
            if ($this->isActive()) {
                session_write_close();
                return $this;
            }
            throw new SessionNotStartedException('Cannot close session, session not started.');
        }

        /**
         * Get the current session ID.
         *
         * @return string The current session ID.
         * @throws SessionNotStartedException If the session is not active.
         */
        public function getId(): string
        {
            return $this->isActive() && session_id()
                ? session_id()
                : throw new SessionNotStartedException('Cannot get session ID, session not started.');
        }

        /**
         * Set the session ID.
         *
         * @param string $id The new session ID.
         * @return static
         * @throws SessionStartedException If the session is already started.
         */
        public function setId(string $id): self
        {
            if (!$this->isActive()) {
                session_id($id);
                return $this;
            }
            throw new SessionStartedException('Cannot set session ID, session already started.');
        }
    }
}