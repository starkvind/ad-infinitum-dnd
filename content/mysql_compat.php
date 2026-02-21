<?php
/**
 * mysql_* compatibility layer for legacy code running on PHP 7/8.
 * It maps common mysql_* calls to mysqli_* equivalents.
 */

if (!defined('MYSQL_ASSOC')) {
    define('MYSQL_ASSOC', 1);
}
if (!defined('MYSQL_NUM')) {
    define('MYSQL_NUM', 2);
}
if (!defined('MYSQL_BOTH')) {
    define('MYSQL_BOTH', 3);
}

if (!isset($GLOBALS['__mysql_compat_link'])) {
    $GLOBALS['__mysql_compat_link'] = null;
}

if (!function_exists('mysql_connect')) {
    function mysql_connect($server = null, $username = null, $password = null, $new_link = false, $client_flags = 0)
    {
        $link = @mysqli_connect($server, $username, $password);
        if ($link instanceof mysqli) {
            $GLOBALS['__mysql_compat_link'] = $link;
        }
        return $link;
    }
}

if (!function_exists('mysql_select_db')) {
    function mysql_select_db($database_name, $link_identifier = null)
    {
        $link = $link_identifier ?: ($GLOBALS['__mysql_compat_link'] ?? null);
        if (!($link instanceof mysqli)) {
            return false;
        }
        return mysqli_select_db($link, $database_name);
    }
}

if (!function_exists('mysql_query')) {
    function mysql_query($query, $link_identifier = null)
    {
        $link = $link_identifier ?: ($GLOBALS['__mysql_compat_link'] ?? null);
        if (!($link instanceof mysqli)) {
            return false;
        }
        return mysqli_query($link, $query);
    }
}

if (!function_exists('mysql_num_rows')) {
    function mysql_num_rows($result)
    {
        if (!($result instanceof mysqli_result)) {
            return 0;
        }
        return mysqli_num_rows($result);
    }
}

if (!function_exists('mysql_fetch_array')) {
    function mysql_fetch_array($result, $result_type = MYSQL_BOTH)
    {
        if (!($result instanceof mysqli_result)) {
            return false;
        }
        $mode = MYSQLI_BOTH;
        if ($result_type === MYSQL_ASSOC) {
            $mode = MYSQLI_ASSOC;
        } elseif ($result_type === MYSQL_NUM) {
            $mode = MYSQLI_NUM;
        }
        return mysqli_fetch_array($result, $mode);
    }
}

if (!function_exists('mysql_real_escape_string')) {
    function mysql_real_escape_string($unescaped_string, $link_identifier = null)
    {
        $link = $link_identifier ?: ($GLOBALS['__mysql_compat_link'] ?? null);
        if (!($link instanceof mysqli)) {
            return addslashes((string) $unescaped_string);
        }
        return mysqli_real_escape_string($link, $unescaped_string);
    }
}

if (!function_exists('mysql_close')) {
    function mysql_close($link_identifier = null)
    {
        $link = $link_identifier ?: ($GLOBALS['__mysql_compat_link'] ?? null);
        if (!($link instanceof mysqli)) {
            return false;
        }
        $result = mysqli_close($link);
        if ($result) {
            $GLOBALS['__mysql_compat_link'] = null;
        }
        return $result;
    }
}

if (!function_exists('mysql_error')) {
    function mysql_error($link_identifier = null)
    {
        $link = $link_identifier ?: ($GLOBALS['__mysql_compat_link'] ?? null);
        if (!($link instanceof mysqli)) {
            return '';
        }
        return mysqli_error($link);
    }
}

if (!function_exists('mysql_free_result')) {
    function mysql_free_result($result)
    {
        if (!($result instanceof mysqli_result)) {
            return false;
        }
        return mysqli_free_result($result);
    }
}

