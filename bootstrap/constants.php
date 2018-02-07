<?php

declare(strict_types=1);

// environment
if (!defined('ENVIRONMENT')) {
    $env = getenv('MODUS_CREATE_PROJECT_ENVIRONMENT');
    if (!$env) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        exit;
    }
    define('ENVIRONMENT', $env);
}

define('ENVIRONMENT_PRODUCTION', 'production');
define('ENVIRONMENT_DEVELOPMENT', 'development');
define('ENVIRONMENT_TESTING', 'test');
define('ENVIRONMENT_STAGING', 'staging');

// HTTP methods
define('HTTP_METHOD_DELETE', 'DELETE');
define('HTTP_METHOD_GET', 'GET');
define('HTTP_METHOD_HEAD', 'HEAD');
define('HTTP_METHOD_OPTIONS', 'OPTIONS');
define('HTTP_METHOD_PATCH', 'PATCH');
define('HTTP_METHOD_POST', 'POST');
define('HTTP_METHOD_PUT', 'PUT');

// content types
define('CONTENT_TYPE_JSON', 'application/json');
define('CONTENT_TYPE_HTML', 'text/html');

// HTTP allowed content types
define('HTTP_ACCEPT_CONTENT_TYPES', 'application/json'); // types must be separated by comma

// CORS headers
define('ACCESS_CONTROL_ALLOW_ORIGIN', '*');
define('CONTENT_TYPE', 'application/json');
define('ACCESS_CONTROL_ALLOW_HEADERS', 'Content-Type, X-Access-Token');
define('ACCESS_CONTROL_ALLOW_METHODS', 'GET, POST, OPTIONS, PUT, DELETE, PATCH');

// project paths
define('PATH_PROJECT', realpath(__DIR__ . '/../') . '/');
define('PATH_BOOTSTRAP', realpath(PATH_PROJECT . 'bootstrap') . '/');

define('DATE_FORMAT', 'Y-m-d');
define('TIME_FORMAT', 'H:i:s');
define('DATETIME_FORMAT', DATE_FORMAT . ' ' . TIME_FORMAT);
