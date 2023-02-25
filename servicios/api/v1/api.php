<?php
	require __DIR__ . "/inc/bootstrap.php";

	//$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	//$uri=null;
	//$uri = parse_url(substr($_SERVER['REQUEST_URI'],7,strlen($_SERVER['REQUEST_URI'])), PHP_URL_PATH);
	$uri = explode("/",parse_url(substr($_SERVER['REQUEST_URI'],3,strlen($_SERVER['REQUEST_URI'])), PHP_URL_PATH));

	if (!isset($uri[2]) ||
		($uri[2] != 'news' && $uri[2] != 'empresas' && $uri[2] != 'token'&& $uri[2] != 'alertas') ||
		!isset($uri[3])
	) {
		header("HTTP/1.1 404 Not Found");
		exit();
	}


	require PROJECT_ROOT_PATH . "/Controller/Api/NewsController.php";
	require PROJECT_ROOT_PATH . "/Controller/Api/EmpresasController.php";
	require PROJECT_ROOT_PATH . "/Controller/Api/TokenController.php";
	require PROJECT_ROOT_PATH . "/Controller/Api/AlertasController.php";

	if ($uri[2] == 'news')
		$objFeedController = new NewsController();
	elseif ($uri[2] == 'empresas')
		$objFeedController = new EmpresasController();
	elseif ($uri[2] == 'token')
		$objFeedController = new TokenController();
	elseif ($uri[2] == 'alertas')
		$objFeedController = new AlertasController();

	$strMethodName = $uri[3] . 'Action';
	$objFeedController->{$strMethodName}();
