<?php

use App\Controllers\HomeController;
use App\Controllers\admin\ProductController;
use App\Controllers\admin\UserController;
use App\Controllers\admin\OrderController;
use App\Controllers\admin\DashboardController;
use App\Controllers\AuthController;
use App\Controllers\UserDashboardController;

require_once __DIR__ . '/../env.php';
require_once __DIR__ . '/../App/helpers.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

flash_next_request();

require_once __DIR__ . '/../vendor/autoload.php';

$router = new \Bramus\Router\Router();

// Client
$router->get('/', HomeController::class . '@index');
$router->get('/list', HomeController::class . '@shop');

// Auth
$router->get('/login', AuthController::class . '@showLogin');
$router->post('/login', AuthController::class . '@login');
$router->get('/register', AuthController::class . '@showRegister');
$router->post('/register', AuthController::class . '@register');
$router->get('/forgot-password', AuthController::class . '@showForgotPassword');
$router->post('/forgot-password', AuthController::class . '@forgotPassword');
$router->get('/reset-password', AuthController::class . '@showResetPassword');
$router->post('/reset-password', AuthController::class . '@resetPassword');
$router->get('/logout', AuthController::class . '@logout');

// User
$router->get('/user/profile', UserDashboardController::class . '@profile');
$router->post('/user/profile/avatar', UserDashboardController::class . '@uploadAvatar');
$router->post('/user/profile/update', UserDashboardController::class . '@updateProfile');
$router->post('/user/profile/change-password', UserDashboardController::class . '@changePassword');
$router->get('/user/product/{id}', UserDashboardController::class . '@productDetail');
$router->get('/user/cart', UserDashboardController::class . '@cart');
$router->post('/user/cart/add', UserDashboardController::class . '@addToCart');
$router->post('/user/cart/update', UserDashboardController::class . '@updateCart');
$router->post('/user/cart/remove', UserDashboardController::class . '@removeFromCart');
$router->post('/user/cart/clear', UserDashboardController::class . '@clearCart');
$router->get('/user/checkout', UserDashboardController::class . '@checkout');
$router->post('/user/checkout/confirm', UserDashboardController::class . '@confirmCheckout');
$router->get('/user/orders', UserDashboardController::class . '@orders');
$router->get('/user/orders/{id}', UserDashboardController::class . '@orderDetail');
$router->post('/user/orders/{id}/cancel', UserDashboardController::class . '@cancelOrder');

$router->set404(fn() => view('404'));

// Admin
$router->mount('/admin', function () use ($router) {
    $router->get('/', DashboardController::class . '@index');
    $router->get('/dashboard', DashboardController::class . '@index');
    $router->get('/products', ProductController::class . '@index');
    $router->get('/products/add', ProductController::class . '@add');
    $router->post('/products/store', ProductController::class . '@store');
    $router->get('/products/show/{id}', ProductController::class . '@show');
    $router->get('/products/edit/{id}', ProductController::class . '@edit');
    $router->post('/products/update/{id}', ProductController::class . '@update');
    $router->post('/products/autosave/{id}', ProductController::class . '@autoSave');
    $router->post('/products/delete/{id}', ProductController::class . '@delete');

    $router->get('/users', UserController::class . '@index');
    $router->get('/users/add', UserController::class . '@add');
    $router->post('/users/store', UserController::class . '@store');
    $router->get('/users/edit/{id}', UserController::class . '@edit');
    $router->post('/users/update/{id}', UserController::class . '@update');
    $router->post('/users/delete/{id}', UserController::class . '@delete');

    $router->get('/orders', OrderController::class . '@index');
    $router->get('/orders/{id}', OrderController::class . '@show');
    $router->post('/orders/{id}/status', OrderController::class . '@updateStatus');
    $router->post('/orders/{id}/delete', OrderController::class . '@delete');
});

$router->run();
