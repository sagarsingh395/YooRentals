<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
/******************************Error**************************************************/
$routes->get('forbidden', 'ErrorControllers::forbidden');

/*****************************Booking Routes*********************************/
$routes->get('/', 'Home::index');
$routes->get('save-booking', 'Home::saveBooking');

/*****************************payment*********************************/
$routes->post('/create-order', 'Home::createOrder');
$routes->post('/capture-order', 'Home::captureOrder');

/*****************************PDF,EXCEL*********************************/
$routes->match(['get', 'post'], '/invoice/(:any)', 'Home::downloadInvoice/$1');
$routes->match(['get', 'post'], '/exportexcel', 'Test::exportExcel');

/*****************************contact*********************************/
$routes->get('/contact', 'Home::contact');
$routes->match(['get','post'],'/contact/save', 'Home::contact_save');

/*****************************authentication-failed*************************************/
$routes->get('/authentication-failed', function () {
    return view('admin/auth-fail');
});

$routes->group('', ['filter' => 'AuthCheck'], function ($routes) {
    $routes->get('admin/dashboard', 'Admin\Dashboard::index');
    $routes->get('admin/logout', 'Admin\Auth::logout');

    /***************************USER ROUTES***********************************************/
    $routes->get('admin/users', 'Admin\Users::index');
    $routes->match(['get', 'post'], 'admin/add_user', 'Admin\Users::add_user');
    $routes->match(['get', 'post'], 'admin/edit_user/(:num)', 'Admin\Users::edit_user/$1');
    $routes->match(['get', 'post'], 'admin/view_user/(:num)', 'Admin\Users::view_user/$1');
    $routes->match(['get', 'post'], 'admin/delete_user/(:num)', 'Admin\Users::delete_user/$1');
    $routes->match(['get', 'post'], 'admin/doDelete/(:num)', 'Admin\Users::doDelete/$1');

    /**************************Services**************************************************/
    $routes->get('admin/service', 'Service\Services::index');
    $routes->match(['get', 'post'], 'admin/add-service', 'Service\Services::add_service');
    $routes->match(['get', 'post'], 'admin/edit-service/(:num)', 'Service\Services::edit_service/$1');
    $routes->match(['get', 'post'], 'admin/view-service/(:num)', 'Service\Services::view_service/$1');
    $routes->match(['get', 'post'], 'admin/delete-service/(:num)', 'Service\Services::delete_service/$1');

    /**************************category**************************************************/
    $routes->match(['get', 'post'], 'admin/add-category/(:num)', 'Service\ServiceCategory::add_category/$1');
    $routes->match(['get', 'post'], 'admin/edit-category/(:num)', 'Service\ServiceCategory::edit_category/$1');
    $routes->match(['get', 'post'], 'admin/delete-category/(:num)', 'Service\ServiceCategory::delete_category/$1');

    /**************************User Group************************************************/
    $routes->get('admin/user-group', 'Admin\UserGroup::index');
    $routes->match(['get', 'post'], 'admin/add-group', 'Admin\UserGroup::add_group');
    $routes->match(['get', 'post'], 'admin/edit-group/(:num)', 'Admin\UserGroup::edit_group/$1');
    $routes->match(['get', 'post'], 'admin/delete-group/(:num)', 'Admin\UserGroup::delete_group/$1');

    /**************************Setting***************************************************/
    $routes->match(['get', 'post'], 'admin/setting', 'Admin\UserGroup::setting');
    /***************************Product**************************************************/
    $routes->get('admin/products', 'Admin\Product::index');
    $routes->match(['get', 'post'], 'admin/product-cu', 'Admin\Product::add_edit_product');
    $routes->match(['get', 'post'], 'admin/product-cu/(:num)', 'Admin\Product::add_edit_product/$1');

    /************************************Profile*****************************************/
    $routes->match(['get', 'post'], 'admin/profile', 'Admin\Profile::index');
    $routes->match(['get', 'post'], 'admin/profile/change_password', 'Admin\Profile::change_password');
    $routes->match(['get', 'post'], 'admin/edit_profile/(:num)', 'Admin\Profile::edit_profile/$1');
});

$routes->group('', ['filter' => 'AlreadyLoggedIn'], function ($routes) {
    $routes->match(['get', 'post'], '/admin', 'Admin\Auth::login');
});
