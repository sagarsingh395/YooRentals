<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
/************************************* Error *************************************/
// $routes->get('test403', function() {return view('admin/order/view_order');});
$routes->get('forbidden', 'ErrorControllers::forbidden');

/*************************************Public Routes (no auth required)*************************************/
$routes->get('/', 'Home::index');
$routes->get('/product/(:any)', 'Home::product_details/$1');
$routes->match(['get', 'post'], '/add_to_cart', 'Home::add_to_cart');
$routes->match(['get', 'post'], '/checkout', 'Home::checkout');
$routes->match(['get', 'post'], '/test', 'Home::test');

/*************************************authentication-failed*************************************/
$routes->get('/authentication-failed', function () {
    return view('admin/auth-fail');
});

$routes->group('', ['filter' => 'AuthCheck'], function ($routes) {
    $routes->match(['get', 'post'], '/admin/dashboard', 'Admin\Dashboard::index');
    $routes->get('admin/logout', 'Admin\Auth::logout');

    /************************************* USER ROUTES *************************************/

    $routes->get('admin/users', 'Admin\Users::index');
    $routes->match(['get', 'post'], 'admin/add_user', 'Admin\Users::add_user');
    $routes->match(['get', 'post'], 'admin/edit_user/(:num)', 'Admin\Users::edit_user/$1');
    $routes->match(['get', 'post'], 'admin/view_user/(:num)', 'Admin\Users::view_user/$1');
    $routes->match(['get', 'post'], 'admin/delete_user/(:num)', 'Admin\Users::delete_user/$1');
    $routes->match(['get', 'post'], 'admin/doDelete/(:num)', 'Admin\Users::doDelete/$1');

    /************************User Group**************************************** */
    $routes->get('admin/user-group', 'Admin\UserGroup::index');
    $routes->match(['get', 'post'], 'admin/add-group', 'Admin\UserGroup::add_group');
    $routes->match(['get', 'post'], 'admin/edit-group/(:num)', 'Admin\UserGroup::edit_group/$1');
    $routes->match(['get', 'post'], 'admin/delete-group/(:num)', 'Admin\UserGroup::delete_group/$1');

    /************************User Group**************************************** */
    $routes->match(['get', 'post'], 'admin/setting', 'Admin\UserGroup::setting');
    /************************************Product*************************************** */
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
