<?php
	
	namespace App;
	
	/**
	* Класс для обращения к базе данных, не будет меняться 
	* на протяжении всего проекта
	*
	* C его помощью мы сможем делать произвольные запросы к базе данных
	* и получать результаты в виде массива объектов нужного нам класса
	* в соответсвии с ORM. Для упрощения не используем singleton.
	*/
	class Db
	{
		public \PDO $db;
		
		public function __construct()
		{
			try{
				$this->db = new \PDO('mysql:dbname=experimental;host:localhost', 'root', '');
			}catch(\PDOException $e ){
				throw new \Exception('Ошибка соединения с базой данных: ' . $e->getMessage());
			}
		}
		
		public function query(string $sql, $params = [], string $className = \stdClass::class): array
		{
			$sth = $this->db->prepare($sql); // $sth - Statement Handler
			$sth->execute($params);
			
			return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
		}
	}