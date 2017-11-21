<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/*use Slim\Http\Request;
use Slim\Http\Response;
use Slim\App;*/

$app->add(function (Request $request, Response $response, callable $next)  use ($app){
	global $DB;
	$DB=$this->db;
	$obj=new Slimauth();
	$obj->checkAuth($request);	
	if(IS_LOG)
	{
		$log=new Log();
		$log=$log->basic_log_insert($request->isGet()?$request->getQueryParams():$request->getParsedBody());	
	}
    return $next($request, $response);
});