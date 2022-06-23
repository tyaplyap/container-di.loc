<?php
	
	/** Точка входа, наш фронт-контроллер */
	
	spl_autoload_register(function (string $className){
		require_once __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
	});
	
	// $tep 3 - внедряем зависимость через конструктор
	// Это делаем зависимости обязательными, теперь их 
	// невозможно забыть передать
	try{
		$controller = (new \App\UserController(
			new \App\UserRepository(
				new \App\Db()
			)
		));
		echo $controller->handle();
	} catch(\Exception $e){
		echo 'Ошибка: ' . $e->getMessage();
	}