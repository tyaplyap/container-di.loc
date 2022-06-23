<?php
	
	/** Точка входа, наш фронт-контроллер */
	
	spl_autoload_register(function (string $className){
		require_once __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
	});
	
	
	try{
		$controller = new \App\UserController();
		echo $controller->handle();
	}catch(\Exception $e){
		echo 'Ошибка: ' . $e->getMessage();
	}