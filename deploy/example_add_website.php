#!/usr/clearos/sandbox/usr/bin/php
<?php

///////////////////////////////////////////////////////////////////////////////
// B O O T S T R A P
///////////////////////////////////////////////////////////////////////////////

$bootstrap = getenv('CLEAROS_BOOTSTRAP') ? getenv('CLEAROS_BOOTSTRAP') : '/usr/clearos/framework/shared';
require_once $bootstrap . '/bootstrap.php';

///////////////////////////////////////////////////////////////////////////////
// D E P E N D E N C I E S
///////////////////////////////////////////////////////////////////////////////

use \clearos\apps\web_server\Httpd as Httpd;

clearos_load_library('web_server/Httpd');

///////////////////////////////////////////////////////////////////////////////
// M A I N
///////////////////////////////////////////////////////////////////////////////

$options['folder_layout'] = Httpd::FOLDER_LAYOUT_SANDBOX;   // Layout
$options['web_access'] = Httpd::ACCESS_ALL;                 // Remote acces (ACCESS_ALL or ACCESS_LAN)
$options['require_authentication'] = FALSE;                 // Flag for managing basic authentication
$options['show_index'] = FALSE;                             // Flag for managing Apache "Indexes" option
$options['follow_symlinks'] = TRUE;                         // Flag for managing Apache "FollowSymlinks" option
$options['ssi'] = FALSE;                                    // Flag for managing Apache "IncludesNOExec" option
$options['htaccess'] = TRUE;                                // Flag for managing .htaccess support
$options['cgi'] = FALSE;                                    // Flag for CGI support.
$options['php'] = TRUE;                                     // Flag for managing PHP support
$options['php_engine'] = 'rh-php70-php-fpm';                // PHP version.  See below.
$options['ssl_certificate'] = 'sys-0-cert.pem';             // SSL Certificate.  See below.
$options['require_ssl'] = FALSE;                            // Legacy.  Set to FALSE.
$options['custom_configuration'] = FALSE;                   // Legacy.  Set to FALSE.

// PHP versions
// - httpd: PHP 5.4 (the default provided by mod_php)
// - rh-php56-php-fpm: PHP 5.6
// - rh-php70-php-fpm: PHP 7.0
// - rh-php71-php-fpm: PHP 7.1 (requires app-php-engines > 1.1.4)

// SSL Certificates
// - sys-0-cert.pem: default self-signed certificate. Certificate Manager must be initialized first!
// - www.example.com: the primary domain used in a Let's Encrypt certificate

$httpd = new Httpd();
$httpd->add_site(
    'example.lan',        // Primary hostname
    'www.example.lan docs.example.com',  // Aliases
    'allusers',           // Upload group
    FALSE,                // FTP upload state
    FALSE,                // Samba upload state
    Httpd::TYPE_WEB_SITE, // Always Httpd::TYPE_WEB_SITE
    $options
);
