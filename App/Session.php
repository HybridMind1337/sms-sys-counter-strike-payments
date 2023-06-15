<?php
/**
 * @class Session
 * @created 01/04/2023 г.
 *
 * @author HybridMind
 * @email hybridmind1337@gmail.com
 * @discord HybridMind#6095
 *
 */


namespace App;

class Session
{

    /**
     * @param $name
     *
     * @return bool
     */
    public static function exists($name): bool
    {
        if (isset($_SESSION[$name])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $name
     * @param string $value
     *
     * @return string
     */
    public static function put($name, $value = '')
    {
        return $_SESSION[$name] = $value;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public static function get($name)
    {
        return $_SESSION[$name] ?? false;
    }

    /**
     * @param $name
     */
    public static function delete($name)
    {
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public static function flash($name)
    {
        if (self::exists($name)) {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name);
        }
    }

}