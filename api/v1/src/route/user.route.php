<?php 
$app->group('/user', function () {
    $this->post('/login', function ($req, $response, $args) {
	  	$post=$req->getParsedBody();
	  	$obj=new User();
     	$obj->login($post);
    });
    $this->post('/details', function ($req, $response, $args) {
	  	$obj=new User();
     	$obj->login();
    });
});
?>