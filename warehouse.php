<?php

/**
 * Plugin Name: Posti Warehouse Plugin
 * Version: 1.0.6
 * Description: Warehouse plugin for WooCommerce.
 * Author: Posti
 * Author URI: https://www.posti.fi/
 * Text Domain: posti-warehouse
 * Domain Path: /languages/
 * License: GPL v3 or later
 *
 * WC requires at least: 3.4
 * WC tested up to: 4.1
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace PostiWarehouse;
// Prevent direct access to this script
if ( ! defined('ABSPATH') ) {
  exit;
}

define( '__POSTI_WH_FILE__', __FILE__ );

/**
 * Autoloader loads nothing but Pakettikauppa libraries. The classname of the generated autoloader is not unique,
 * posti_shipping forks use the same autoloader which results in a fatal error if the main plugin and a posti_shipping plugin
 * co-exist.
 */
if ( ! class_exists('\Pakettikauppa\Client') ) {
  require_once __DIR__ . '/vendor/autoload.php';
}

require_once __DIR__ . '/Classes/Order.php';
require_once __DIR__ . '/Classes/Metabox.php';
require_once __DIR__ . '/Classes/Api.php';
require_once __DIR__ . '/Classes/Core.php';
require_once __DIR__ . '/Classes/Logger.php';
require_once __DIR__ . '/Classes/Debug.php';
require_once __DIR__ . '/Classes/Product.php';
require_once __DIR__ . '/Classes/Dataset.php';
require_once __DIR__ . '/Classes/Shipping.php';
require_once __DIR__ . '/Classes/Frontend.php';

use PostiWarehouse\Classes\Core;

new Core();



