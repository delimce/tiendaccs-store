<?php
// HTTP
define('HTTP_SERVER', 'http://zserver/tiendaccs/admin/');
define('HTTP_CATALOG', 'http://zserver/tiendaccs/');

// HTTPS
define('HTTPS_SERVER', 'http://zserver/tiendaccs/admin/');
define('HTTPS_CATALOG', 'http://zserver/tiendaccs/');

// DIR
define('DIR_APPLICATION', '/var/www/tiendaccs/admin/');
define('DIR_SYSTEM', '/var/www/tiendaccs/system/');
define('DIR_IMAGE', '/var/www/tiendaccs/image/');
define('DIR_STORAGE', DIR_SYSTEM . 'storage/');
define('DIR_CATALOG', '/var/www/tiendaccs/catalog/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/template/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'delimce');
define('DB_DATABASE', 'tiendaccs_db');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');

// OpenCart API
define('OPENCART_SERVER', 'https://www.opencart.com/');
