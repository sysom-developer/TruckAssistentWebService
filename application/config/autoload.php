<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default. For example,
| the database is not connected to automatically since no assumption
| is made regarding whether you intend to use it.  This file lets
| you globally define which systems you would like loaded with every
| request.
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
|
| These are the things you can load automatically:
|
| 1. Packages
| 2. Libraries
| 3. Drivers
| 4. Helper files
| 5. Custom config files
| 6. Language files
| 7. Models
|
*/

/*
| -------------------------------------------------------------------
|  Auto-load Packages
| -------------------------------------------------------------------
| Prototype:
|
|  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
|
*/

$autoload['packages'] = array();


/*
| -------------------------------------------------------------------
|  Auto-load Libraries
| -------------------------------------------------------------------
| These are the classes located in the system/libraries folder
| or in your application/libraries folder.
|
| Prototype:
|
|	$autoload['libraries'] = array('database', 'email', 'session');
|
| You can also supply an alternative library name to be assigned
| in the controller:
|
|	$autoload['libraries'] = array('user_agent' => 'ua');
*/

$autoload['libraries'] = array('session', 'upload', 'pagination', 'encrypt', 'seccode', 'upload_conf', 'curl', 'service', 'sms');


/*
| -------------------------------------------------------------------
|  Auto-load Drivers
| -------------------------------------------------------------------
| These classes are located in the system/libraries folder or in your
| application/libraries folder within their own subdirectory. They
| offer multiple interchangeable driver options.
|
| Prototype:
|
|	$autoload['drivers'] = array('cache');
*/

$autoload['drivers'] = array();


/*
| -------------------------------------------------------------------
|  Auto-load Helper Files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['helper'] = array('url', 'file');
*/

$autoload['helper'] = array('url', 'file', 'security', 'cookie', 'random', 'random_number', 'rand_uniqid_helper', 'greeting', 'cut_str', 'chang_image_size', 'log', 'delete_html', 'get_lang_type_helper', 'upload_img_file', 'static_url', 'words_filter', 'move_upload_file', 'get_order_sn', 'get_location_by_lat_lng', 'get_stay_time', 'json_en', 'multi_array_sort', 'get_week', 'push_xingeapp', 'tran_time', 'get_residual_mileage', 'get_lat_lng_by_location', 'string_secret', 'secret_string', 'get_first_charter');


/*
| -------------------------------------------------------------------
|  Auto-load Config files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['config'] = array('config1', 'config2');
|
| NOTE: This item is intended for use ONLY if you have created custom
| config files.  Otherwise, leave it blank.
|
*/

$autoload['config'] = array('global_config', 'driver_anomaly_text_config');


/*
| -------------------------------------------------------------------
|  Auto-load Language files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['language'] = array('lang1', 'lang2');
|
| NOTE: Do not include the "_lang" part of your file.  For example
| "codeigniter_lang.php" would be referenced as array('codeigniter');
|
*/

$autoload['language'] = array();


/*
| -------------------------------------------------------------------
|  Auto-load Models
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['model'] = array('first_model', 'second_model');
|
| You can also supply an alternative model name to be assigned
| in the controller:
|
|	$autoload['model'] = array('first_model' => 'first');
*/

$autoload['model'] = array('common_model');

$autoload['service'] = array('driver_service', 'shipper_service', 'shipper_route_service', 'shipper_company_service', 'route_service', 'user_dispatch_service', 'city_service', 'attachment_service', 'vehicle_service', 'orders_service', 'shipper_driver_service', 'region_service', 'goods_category_service', 'tracking_service', 'order_log_service', 'driver_anomaly_service', 'comment_service', 'driver_message_service', 'driver_history_region_service', 'driver_score_log_service', 'product_score_service', 'driver_exchange_product_score_log_service', 'vehicle_location_service', 'driver_update_log_service', 'driver_join_company_log_service', 'shipper_company_score_log_service');