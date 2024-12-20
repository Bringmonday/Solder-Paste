<?php

use CodeIgniter\Router\RouteCollection;
use CodeIgniter\Router\Route;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultController('Login');
$routes->get('/', 'Login::index');
$routes->get('login', 'Login::index');
$routes->get('logout', 'Login::index');
$routes->post('loginMe', 'Login::loginMe');
$routes->get('register', 'Register::index');
$routes->post('registerMe', 'Register::registerMe');
$routes->post('user/save_temp_data', 'User::save_temp_data');
$routes->post('user/save_temp_dataoff', 'User::save_temp_dataoff');
$routes->post('user/save_timewarehouse', 'User::save_timewarehouse');
$routes->post('user/save_timewarehouse_search_key', 'User::save_timewarehouse_search_key');
$routes->post('user/save_timeproduksi_search_key', 'User::save_timeproduksi_search_key');
$routes->post('user/save_timeproduksi_lot_number', 'User::save_timeproduksi_lot_number');
$routes->post('user/save_timeoffprod_search_key', 'User::save_timeoffprod_search_key');
$routes->post('user/save_timewarehouse_scrap_to_return', 'User::save_timewarehouse_scrap_to_return');
$routes->post('user/save_timewarehouse_external', 'User::save_timewarehouse_external');
$routes->post('user/check_timestamps', 'User::check_timestamps');
$routes->get('user/checkPendingNotifications', 'User::checkPendingNotifications');
$routes->get('user/checkOverdueNotifications', 'User::checkOverdueNotifications');
$routes->get('user/getNotifications', 'User::getNotifications');
$routes->get('user/getNotificationsProd', 'User::getNotificationsProd');
$routes->get('user/getNotificationsOffProd', 'User::getNotificationsOffProd');
$routes->post('user/update_lot_number', 'User::update_lot_number');
$routes->post('user/received', 'User::received');
$routes->post('user/receivedoffprod', 'User::receivedoffprod');
$routes->get('user/export_to_excel', 'User::export_to_excel');
$routes->get('user/search_keys_lot_number', 'User::search_keys_lot_number');
$routes->get('user/display_return_data', 'User::display_return_data');
$routes->get('user/search_key', 'User::search_key');
$routes->get('user/search_key_prod', 'User::search_key_prod');
$routes->get('user/search_key_offprod', 'User::search_key_offprod');
$routes->get('user/search_key_incoming', 'User::search_key_incoming');
$routes->get('user/search_key_ext', 'User::search_key_ext');
$routes->post('user/check_time_difference', 'User::check_time_difference');
$routes->post('user/get_last_timestamp', 'User::get_last_timestamp');
$routes->post('user/check_data_exists', 'User::check_data_exists');


$routes->group('admnwarehouse', ['filter' => 'authRole:1'], function ($routes) {
    $routes->get('dashboardwrhs', 'User::admnwarehouseDashboard');
    $routes->get('warehouse_form', 'User::warehouse_form');
    $routes->get('processing_form_warehouse', 'User::processing_form_warehouse');
    $routes->get('xacti_aji', 'User::xacti_aji');
    $routes->get('return_form', 'User::return_form');
    $routes->get('scrap_to_return', 'User::scrap_to_return');
    $routes->get('profilewrhs', 'Role::profilewrhs');
    $routes->post('updatePasswordwrhs', 'Role::updatePasswordwrhs');
});

$routes->group('admnproduksi', ['filter' => 'authRole:2'], function ($routes) {
    $routes->get('dashboardprod', 'User::admnproduksiDashboard');
    $routes->get('processing_form_produksi', 'User::processing_form_produksi');
    $routes->get('warehouse_form', 'User::warehouse_form');
    $routes->get('profileprod', 'Role::profileprod');
    $routes->post('updatePasswordprod', 'Role::updatePasswordprod');
});

$routes->group('admnoffprod', ['filter' => 'authRole:3'], function ($routes) {
    $routes->get('dashboardoffprod', 'User::admnoffprodDashboard');
    $routes->get('offprod_form', 'User::offprod_form');
    $routes->get('processing_form_offprod', 'User::processing_form_offprod');
    $routes->get('returnoffprod_form', 'User::returnoffprod_form');
    $routes->get('profileoffprod', 'Role::profileoffprod');
    $routes->post('updatePasswordoffprod', 'Role::updatePasswordoffprod');
});

$routes->get('dashboard', 'DefaultDashboard::index');
