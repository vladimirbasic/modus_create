<?php

require_once PATH_BOOTSTRAP . 'errorHandler.php';
require_once PATH_BOOTSTRAP . 'dependencies.php';
require_once PATH_BOOTSTRAP . 'providers.php';
require_once PATH_BOOTSTRAP . 'routes.php';
require_once PATH_BOOTSTRAP . 'beforeMiddleware.php';
require_once PATH_BOOTSTRAP . 'afterMiddleware.php';
// override default provider classes where needed
require_once PATH_BOOTSTRAP . 'overrideDefaults.php';
