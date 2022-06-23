<?php
	
	namespace App;
	
	/**
	* Класс User не будет меняться на протяжении всего проекта
	*
	* Названия полей класса соответсвуют названиям столбцов в 
	* таблице `users` в базе данных, для реализации ORM
	*/
	class User
	{
		public int $id;
		public string $name;
		public string $email;
	}