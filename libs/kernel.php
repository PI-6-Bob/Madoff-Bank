<?php

require_once 'libs/autoloader.php';
require_once 'libs/utils.php';

# Load ini files for configuration
$_ENV += parse_ini_file(__DIR__ . '/../site.env', true);
if (file_exists(__DIR__ . '/../local.ini')) # Load local file if exists
	$_ENV += parse_ini_file(__DIR__ . '/../local.env', true);

# Set the configuration for php
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.cookie_httponly', 1);
header_remove('X-Powered-By');

