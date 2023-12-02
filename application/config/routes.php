<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'UserController';
$route['login'] = 'UserController/login';
$route['register'] = 'PublicController/register';
// $route['my-task'] = 'PublicController/my_task';
$route['my-task/(:any)'] = 'Pendaftar/start_exam/$1';
$route['search/(:num)'] = 'PublicController/searchDetail/$1';
$route['search/(:num)/(:num)'] = 'PublicController/searchAbsen/$1/$2';
$route['search'] = 'PublicController/search';
$route['search-process'] = 'PublicController/searchProcess';
$route['search-kelas'] = 'PublicController/searchKelas';
$route['search-evaluasi'] = 'PublicController/searchEvaluasi';
$route['search-mapping'] = 'PublicController/searchMapping';
$route['login/(:any)'] = 'UserController/login/$1';
$route['login-process'] = 'UserController/loginProcess';
$route['logout'] = 'UserController/logout';
$route['change-password'] = 'UserController/changePassword';
$route['change-password-process'] = 'UserController/changePasswordProcess';
$route['register-process'] = 'PublicController/registerProcess';
$route['lupa-password'] = 'PublicController/lupaPassword';
$route['reset-process'] = 'PublicController/resetProcess';
$route['student'] = 'PublicController/my_task';
$route['guest'] = 'GuestController/index';
$route['activator/(:num)/(:any)'] = "PublicController/activator/$1/$2";
$route['reset2-process'] = 'PublicController/reset2Process';
$route['reset/(:num)/(:any)'] = "PublicController/reset/$1/$2";


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
