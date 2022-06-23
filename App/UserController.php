<?php
	
	namespace App;
	
	/**
	* Контроллер с единственным методом, который вызывает 
	* метод репозитария для поиска пользователя
	*/
	class UserController
	{
		public function handle()
		{
			// Создаем зависимость от UserRepository
			// прямо в методе, на лету
			$repo = new UserRepository(); 
			
			// Здесь email мы должны получить из $_POST['email'];
			$user = $repo->findByEmail('zakhar@mail.ru');
			
			if($user === null){
				throw new \Exception('Пользователь с таким email не найден');
			}
			return 'Имя пользователя: ' . $user->name;
		}
	}