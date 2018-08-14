<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'web_server';
$app['version'] = '2.5.1';
$app['release'] = '1';
$app['vendor'] = 'ClearFoundation';
$app['packager'] = 'ClearFoundation';
$app['license'] = 'GPLv3';
$app['license_core'] = 'LGPLv3';
$app['description'] = lang('web_server_app_description');

/////////////////////////////////////////////////////////////////////////////
// App name and categories
/////////////////////////////////////////////////////////////////////////////

$app['name'] = lang('web_server_app_name');
$app['category'] = lang('base_category_server');
$app['subcategory'] = lang('base_subcategory_web');

/////////////////////////////////////////////////////////////////////////////
// Controllers
/////////////////////////////////////////////////////////////////////////////

$app['controllers']['web_server']['title'] = $app['name'];
$app['controllers']['settings']['title'] = lang('base_settings');
$app['controllers']['sites']['title'] = lang('web_server_web_sites');

/////////////////////////////////////////////////////////////////////////////
// Packaging
/////////////////////////////////////////////////////////////////////////////

// app-php-core creates circular dep, so use 'requires' instead of 'core_requires'
$app['requires'] = array(
    'app-accounts',
    'app-certificate-manager',
    'app-groups',
    'app-users',
    'app-network',
    'app-php-core >= 1:1.4.40',
);

$app['core_requires'] = array(
    'app-certificate-manager-core >= 1:2.4.5',
    'app-network-core >= 1:2.4.2',
    'app-flexshare-core >= 1:2.4.5',
    'httpd >= 2.2.15',
    'mod_authnz_external',
    'mod_authz_unixgroup',
    'mod_ssl',
    'openssl >= 1.0.1e-16.el6_5.7',
    'perl-CGI',
    'pwauth',
    'syswatch >= 6.2.3',
);

$app['core_directory_manifest'] = array(
    '/var/clearos/web_server' => array(),
    '/var/clearos/web_server/backup' => array(),
    '/var/www/virtual' => array()
);

$app['core_file_manifest'] = array(
    'httpd.php'=> array('target' => '/var/clearos/base/daemon/httpd.php'),
    'filewatch-web-server-configuration.conf'=> array('target' => '/etc/clearsync.d/filewatch-web-server-configuration.conf'),
);

$app['delete_dependency'] = array(
    'app-web-server-core',
    'httpd',
    'mod_authnz_external',
    'mod_authz_unixgroup',
    'mod_ssl',
);
