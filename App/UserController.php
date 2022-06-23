<?php
	
	namespace App;
	
	/** Step 3 - внедряем зависимость через конструктор
	* Контроллер с единственным методом, который вызывает 
	* метод репозитария для поиска пользователя
	*/
	class UserController
	{
		private UserRepository $userRepository;
		
		// Внедряем зависимость через конструктор 
		// вместо создания вручную через сеттер
		public function __construct(UserRepository $userRepository)
		{
			$this->userRepository = $userRepository;
		}
		
		public function handle()
		{
			// Здесь email мы должны получить из $_POST['email'];
			$user = $this->userRepository->findByEmail('zakhar@mail.ru');
			
			if($user === null){
				throw new \Exception('Пользователь с таким email не найден');
			}
			return 'Имя пользователя: ' . $user->name;
		}
	}