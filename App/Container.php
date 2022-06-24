<?php
	
	namespace App;
	
	/** Step 5 */
	class Container
	{
		private array $objects = [];
		
		public function __construct()
		{
			// Ключи в этом массиве - полные имена классов
			// Значения - стрелочные функции, строящие нужный объект
			// Тем самым мы добиваемся "ленивой" инициализации объектов,
			// они создаются только в тот момент, когда запрашиваются.
			$this->objects = [
				Db::class => fn() => new Db(),
				UserRepository::class => fn() => new UserRepository($this->get(Db::class)),
				UserController::class => fn() => new UserController($this->get(UserRepository::class))
			];
		}
		
		public function has(string $id): bool
		{
			return isset($this->objects[$id]);
		}
		
		public function get(string $id): object // или mixed
		{
			// по идентификатору (теперь это полное имя класса) 
			// вызываем функцию, создающую объект
			return $this->objects[$id]();
		}
	}