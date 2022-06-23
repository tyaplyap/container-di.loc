<?php
	
	namespace App;
	
	/** Step 3 - внедряем зависимость через конструктор
	* Простейший репозиторий с одним методом, который 
	* будет возвращать нам пользователя по его email
	*/
	class UserRepository
	{
		private Db $db;
		
		// Внедряем зависимость через конструктор 
		// вместо создания вручную через сеттер
		public function __construct(Db $db)
		{
			$this->db = $db;
		}
		
		public function findByEmail(string $email): ?User
		{
			$result = $this->db->query(
				'SELECT * FROM `users` WHERE `email` = :email LIMIT 1',
				[':email' => $email],
				User::class
			);
			
			return ! empty($result) ? $result[0] : null;
		}
	}