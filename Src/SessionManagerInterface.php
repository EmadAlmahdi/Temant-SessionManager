<?php declare(strict_types=1);

namespace Temant\SessionManager;

use Temant\SessionManager\Exceptions\SessionStartedException;

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
     * Start a new session or resume the existing session.
     *
     * @param array{
     *     save_path?: string,
     *     name?: string,
     *     save_handler?: string,
     *     gc_probability?: int,
     *     gc_divisor?: int,
     *     gc_maxlifetime?: int,
     *     serialize_handler?: string,
     *     cookie_lifetime?: int,
     *     cookie_path?: string,
     *     cookie_domain?: string,
     *     cookie_secure?: bool,
     *     cookie_httponly?: bool,
     *     cookie_samesite?: 'Strict'|'Lax'|'None'|"",
     *     use_strict_mode?: bool,
     *     use_cookies?: bool,
     *     use_only_cookies?: bool,
     *     referer_check?: string,
     *     cache_limiter?: string,
     *     cache_expire?: int,
     *     use_trans_sid?: bool,
     *     trans_sid_tags?: string,
     *     trans_sid_hosts?: string,
     *     sid_length?: int,
     *     sid_bits_per_character?: int,
     *     lazy_write?: bool
     * } $options Array of session configuration options.
     *
     * @return bool True if the session was successfully started, false otherwise.
     * @throws SessionStartedException If the session is already started.
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