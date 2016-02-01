<?php

// API user list
$app->get('/api/users', 'WebService\Controller\ApiController::userListAction')->bind('api_users');

// API user view
$app->get('/api/user/{id}', 'WebService\Controller\ApiController::userViewAction')->assert('id', '\d+')->bind('api_user_view');