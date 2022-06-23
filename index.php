<?php
	
	/** Точка входа, наш фронт-контроллер */
	
	spl_autoload_register(function (string $className){
		require_once __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
	});
	
	// $tep 2 - внедряем зависимости через сеттеры.
	// Теперь мы наглядно видим, какой объект у нас зависит от других объектов 
	// и от каких именно и управляем этими зависимостями с помощью сеттеров.
	try{
		$controller = (new \App\UserController())
			->setUserRepository(
				(new \App\UserRepository())
					->setDb(new \App\Db())
			)
		;
		echo $controller->handle();
	} catch(\Exception $e){
		echo 'Ошибка: ' . $e->getMessage();
	}