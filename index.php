<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);
Routing::get('', 'DefaultController');
Routing::get('login', 'DefaultController');
Routing::get('registration', 'DefaultController');
Routing::post('confirmlogin', 'SecurityController');
Routing::post('addAdvertisement', 'AdvertisementController');
Routing::get('addAdvertisement', 'AdvertisementController');
Routing::post('confirmRegistration', 'RegistrationController');
Routing::get('getUserAdvertisements', 'AdvertisementController');
Routing::post('getUserAdvertisements', 'AdvertisementController');
Routing::get('deleteAdvertisement', 'AdvertisementController');
Routing::get('modifyAdvertisement', 'AdvertisementController');
Routing::post('getAdvertisementByPlace', 'AdvertisementController');
Routing::post('indexWithAdvertisements', 'DefaultController');
Routing::post('sendComment', 'CommentsController');
Routing::post('getPhoneNumber', 'DefaultController');
Routing::post('like', 'LikeController');
Routing::post('likedAdvertisements', 'LikeController');
Routing::get('getAdvertisement', 'AdvertisementController');
Routing::post('modifyProfile', 'RegistrationController');
Routing::post('getUserCredentials', 'RegistrationController');
Routing::get('logout', 'DefaultController');
Routing::get('getNotifications', 'CommentsController');
Routing::get('deleteComment', 'CommentsController');
Routing::get('deleteAdvertisementAdmin', 'AdvertisementController');
Routing::run($path);