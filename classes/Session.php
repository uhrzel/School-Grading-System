<?php

class Session
{
    public static function exists($name)
    {
        return (isset($_SESSION[$name])) ? true : false;
    }

    public static function put($name, $value)
    {
        return $_SESSION[$name] = $value;
    }

    public static function get($name)
    {
        return $_SESSION[$name];
    }

    public static function delete($name)
    {
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    public static function flash($name, $string = '')
    {
        if (self::exists($name)) {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name, $string);
        }
    }


    public static function display_session_msg()
    {
        if (self::exists('success')) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> ' . self::get('success') . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            self::delete('success');
        } elseif (self::exists('error')) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> ' . self::get('error') . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            self::delete('error');
        } elseif (self::exists('info')) {
            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Info!</strong> ' . self::get('info') . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            self::delete('info');
        } elseif (self::exists('warning')) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Warning!</strong> ' . self::get('warning') . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            self::delete('warning');
        } elseif (self::exists('primary')) {
            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Primary!</strong> ' . self::get('primary') . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            self::delete('primary');
        } elseif (self::exists('secondary')) {
            echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert">
                    <strong>Secondary!</strong> ' . self::get('secondary') . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            self::delete('secondary');
        } elseif (self::exists('light')) {
            echo '<div class="alert alert-light alert-dismissible fade show" role="alert">
                    <strong>Light!</strong> ' . self::get('light') . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            self::delete('light');
        } elseif (self::exists('dark')) {
            echo '<div class="alert alert-dark alert-dismissible fade show" role="alert">
                    <strong>Dark!</strong> ' . self::get('dark') . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            self::delete('dark');
        } else {
            return false;
        }
    }
}
