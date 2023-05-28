<?php

return [
    'GET|/' => \Felipe\Controller\VideoListController::class,
    'GET|/novo-video' => \Felipe\Controller\VideoFormController::class,
    'POST|/novo-video' => \Felipe\Controller\NewVideoController::class,
    'GET|/editar-video' => \Felipe\Controller\VideoFormController::class,
    'POST|/editar-video' => \Felipe\Controller\EditVideoController::class,
    'GET|/remover-video' => \Felipe\Controller\DeleteVideoController::class,
    'GET|/login' => \Felipe\Controller\LoginFormController::class,
    'POST|/login' => \Felipe\Controller\LoginController::class,
    'GET|/logout' => \Felipe\Controller\LogoutController::class,
    'GET|/videos-json' => \Felipe\Controller\JsonVideoListController::class,
    'POST|/videos' => \Felipe\Controller\NewJsonVideoController::class,
];