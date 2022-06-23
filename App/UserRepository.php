<?php
	
	namespace App;
	
	/**
	* Простейший репозиторий с одним методом, который 
	* будет возвращать нам пользователя по его email
	*/
	class UserRepository
	{
		public function findByEmail(string $email): ?User
		{
			// Создаем зависимость от объекта класса Db прям в методе.
			// Созаем объект, так сказать, на лету, там, где он нам понадобился
			$db = new Db(); 
			
			$result = $db->query(
				'SELECT * FROM `users` WHERE `email` = :email LIMIT 1',
				[':email' => $email],
				User::class
			);
			
			return ! empty($result) ? $result[0] : null;
		}
	}