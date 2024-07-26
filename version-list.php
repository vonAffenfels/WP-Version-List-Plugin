<?php
/**
 * Plugin Name:       Version List
 * Description:       WordPress Plugin to send current Versions to VA Api
 * Version:           1.1.1
 * Requires at least: 5.9.3
 * Author:            vonAffenfels <niklas.nellinger@vonaffenfels.de>
 * Author URI:        https://www.vonaffenfels.de
 */


use VersionList\Plugin;

$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
}

$plugin = new Plugin();
$plugin->init();


