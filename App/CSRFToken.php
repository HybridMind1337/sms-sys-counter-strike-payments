<?php
/**
 * @class CSRFToken
 * @created 01/04/2023 г.
 *
 * @author HybridMind
 * @email hybridmind1337@gmail.com
 * @discord HybridMind#6095
 *
 */


namespace App;

class CSRFToken
{
    /**
     * @var string
     */
    public string $session_prefix = 'form_';

    /**
     * @var
     */
    private static $_token;

    /**
     * Generate a CSRF token.
     *
     * @param string $key Key for this token
     * @return string
     */
    public function generate(string $key = 'token')
    {
        $this->sanitizeKey($key);
        try {
            return $this->createToken();
        } catch (\Exception $e) {
            die('Something goes wrong while generating csrf token, please contact us');
        }
    }


    /**
     * Check the CSRF token is valid.
     *
     * @param string $key Key for this token
     * @param string $token The token string (usually found in $_POST)
     * @param int|null $timespan Makes the token expire after $timespan seconds (null = never)
     * @param boolean $multiple Makes the token reusable and not one-time (Useful for ajax-heavy requests)
     */
    public function check(string $key, string $token, int $timespan = null, $multiple = false)
    {
        $key = $this->sanitizeKey($key);

        if (!$token) {
            return false;
        }


        $sessionToken = Session::get($this->session_prefix . $key);
        if (!$sessionToken) {
            return false;
        }

        if (!$multiple) {
            Session::put($this->session_prefix . $key, null);
        }

        if ($this->referralHash() !== substr(base64_decode($sessionToken), 10, 40)) {
            return false;
        }

        if ($token !== $sessionToken) {
            return false;
        }

        // Check for token expiration
        if (is_int($timespan) && ((int)substr(base64_decode($sessionToken), 0, 10) + $timespan) < time()) {
            return false;
        }
        return true;
    }

    /**
     * Sanitize the session key.
     *
     * @param string $key
     * @return string
     */
    protected function sanitizeKey($key)
    {
        return preg_replace('/[^a-zA-Z0-9]+/', '', $key);
    }

    /**
     * Create a new token.
     *
     * @return string
     * @throws Exception
     */
    protected function createToken(): string
    {
        return base64_encode(time() . $this->referralHash() . $this->randomString());
    }

    /**
     * Return a unique referral hash.
     *
     * @return string
     */
    protected function referralHash()
    {
        return sha1($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * Generate a random string.
     *
     * @return string
     * @throws Exception
     * @throws \Exception
     */
    protected function randomString(): string
    {
        return sha1(random_bytes(32));
    }
}