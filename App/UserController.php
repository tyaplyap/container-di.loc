<?php
	
	namespace App;
	
	/** Step 2 - внедряем зависимость через сеттер
	* Контроллер с единственным методом, который вызывает 
	* метод репозитария для поиска пользователя
	*/
	class UserController
	{
		private UserRepository $userRepository;
		
		// Явно, из вне, внедрим зависимость от экземпляра 
		// класса UserRepository через сеттер
		public function setUserRepository(UserRepository $userRepository): self
		{
			$this->userRepository = $userRepository;
			
			return $this;
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