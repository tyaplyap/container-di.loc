<?php
	
	/** Точка входа, наш фронт-контроллер */
	
	spl_autoload_register(function (string $className){
		require_once __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
	});
	
	// $tep 4 - получаем все зависимости через контейнер
	try{
		$controller = (new \App\Container())
			->get('userController');
			
		echo $controller->handle();
	} catch(\Exception $e){
		echo 'Ошибка: ' . $e->getMessage();
	}