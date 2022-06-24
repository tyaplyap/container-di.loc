<?php
	
	namespace App;
	
	/** Step 4 - добавляем в проект контейнер
	*
	* Перенtсем логику получения объектов в контейнер.
	*/
	class Container
	{
		private array $objects = [];
		
		public function __construct()
		{
			// Ключи в этом массиве - строковые ID объектов
			// Значения - стрелочные функции, строящие нужный объект
			// Тем самым мы добиваемся "ленивой" инициализации объектов,
			// они создаются только в тот момент, когда запрашиваются.
			$this->objects = [
				'db' => fn() => new Db(),
				'userRepository' => fn() => new UserRepository($this->get('db')),
				'userController' => fn() => new UserController($this->get('userRepository'))
			];
		}
		
		public function has(string $id): bool
		{
			return isset($this->objects[$id]);
		}
		
		public function get(string $id): object // или mixed
		{
			// по строковому идентификатору вызываем функцию, создающую объект
			return $this->objects[$id]();
		}
	}