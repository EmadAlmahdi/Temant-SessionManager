<?php declare(strict_types=1);

namespace Temant\SessionManager {
    interface SessionManagerInterface
    {
        /**
         * Checks if the session is currently active.
         *
         * @return bool True if the session is active, false otherwise.
         */
        public function isActive(): bool;

        /**
         * Sets the session name.
         *
         * @param string $name The name of the session.
         * @return static
         */
        public function setName(string $name): self;

        /**
         * Starts a new session or resumes the existing session.
         *
         * @param array<string, mixed> $options Array of session configuration options.
         * @return bool True if the session was successfully started, false otherwise.
         */
        public function start(array $options = []): bool;

        /**
         * Sets a session variable.
         *
         * @param string $key The name of the session variable.
         * @param mixed $value The value to set.
         * @return static
         */
        public function set(string $key, mixed $value): self;

        /**
         * Gets the value of a session variable.
         *
         * @param string $key The name of the session variable.
         * @return mixed The value of the session variable, or null if it doesn't exist.
         */
        public function get(string $key): mixed;

        /**
         * Gets the value of all session variables.
         *
         * @return array<string, mixed> An array of all session variables.
         */
        public function all(): array;

        /**
         * Checks if a session variable exists.
         *
         * @param string $key The name of the session variable.
         * @return bool True if the session variable exists, false otherwise.
         */
        public function has(string $key): bool;

        /**
         * Removes a session variable.
         *
         * @param string $key The name of the session variable to remove.
         * @return static
         */
        public function remove(string $key): self;

        /**
         * Regenerates the session ID.
         *
         * @param bool $deleteOldSession Whether to delete the old session data or not.
         * @return bool True if the session ID was regenerated, false otherwise.
         */
        public function regenerate(bool $deleteOldSession = true): bool;

        /**
         * Destroys the current session.
         *
         * @return bool True if the session was successfully destroyed, false otherwise.
         */
        public function destroy(): bool;

        /**
         * Closes the current session and writes session data.
         *
         * @return static
         */
        public function close(): self;

        /**
         * Gets the current session ID.
         *
         * @return string The current session ID.
         */
        public function getId(): string;

        /**
         * Sets the session ID.
         *
         * @param string $id The new session ID.
         * @return static
         */
        public function setId(string $id): self;
    }
}