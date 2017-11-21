<?php
require "../../config.php";

$app_version="v1";
$mode=$PROJECT['database'][$app_version]['mode'];//"devlpoer";
$sub_folder=$PROJECT['folder']['sub_folder'];
$api_version="api/v1";
$auth_enable=true;
$is_log=false;
$config= [
    'settings' => [
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false, 
        "db" => [
            "host" => $PROJECT['database'][$app_version]['db_host'],
            "dbname" => $PROJECT['database'][$app_version]['db_name'],
            "dbname_developer" => $PROJECT['database'][$app_version]['developer_db_name'],
            "user" => $PROJECT['database'][$app_version]['db_user'],
            "pass" => $PROJECT['database'][$app_version]['db_password'],
            "mode" => $mode
        ],
    ],
];