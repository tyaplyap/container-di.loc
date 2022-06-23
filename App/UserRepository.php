<?php
	
	namespace App;
	
	/** Step 2 - внедряем зависимость через сеттер
	* Простейший репозиторий с одним методом, который 
	* будет возвращать нам пользователя по его email
	*/
	class UserRepository
	{
		private Db $db;
		
		// Явно, из вне, внедрим зависимость от 
		// экземпляра класса Db через сеттер
		public function setDb(Db $db): self
		{
			$this->db = $db;
			
			return $this;
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