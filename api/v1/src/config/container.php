<?php
$container = $app->getContainer();
$DB=$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    
    $dbname=$settings['mode']!="devlpoer"?$settings['dbname']:$settings['dbname_developer'];   
    $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $dbname,
        $settings['user'], $settings['pass']);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->query("SET SESSION group_concat_max_len = 100000000");
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        _json(404,"Method Not Found");
    };
};
$app->get('/', function ($request, $response, $args) {
    _json(200,"Welcome To our api");
});