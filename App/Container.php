<?php
	
	namespace App;
	
	/** Step 6 - добавляем рефлексию, делаем autowiring - авторазрешение зависимостей 
	*
	* Класс Container - контейнер внедрения зависимости Container DI
	* c авторазрешением зависимостей через рефлексию
	*/
	class Container
	{
		private array $objects = [];
		
		public function has(string $id): bool
		{
			// Проверяем наличие и в массиве, и в пространстве имен
			// Если не зарегистрирован в массиве, но есть в пространстве имен,
			// то будет создан автоматически при запросе через метод $this->get();
			return isset($this->objects[$id]) || class_exists($id);
		}
		
		/**
		* Возвращает объект класса по его id
		*
		* @var string $id - полное имя класса \App\MyClass::class
		*/
		public function get(string $id): object // или mixed
		{
			// Старый подход - (step 5) вернет объект из $objects, если он там. 
			// Внедрить функцию, строющуюу объект можно вручную, дописав сеттер в контейнер
			// Новый подход - создаст объект, автоматически внедрив в него нужные зависимости
			return 
				isset($this->objects[$id])
				? $this->objects[$id]() // старый подход
				: $this->prepareObject($id); // новый подход
		}
		
		private function prepareObject(string $class): object
		{
			// Создаем рефлектор класса по его имени
			$classReflector = new \ReflectionClass($class);
			
			// Получаем рефлектор конструктора класса
			$constructor = $classReflector->getConstructor();
			
			// Если конструктора нет - сразу возвращаем экземпляр класса
			if($constructor === null){
				return new $class();
			}
			
			// Получаем рефлекторы аргументов конструктора
			$constructArguments = $constructor->getParameters();
			
			// Если аргументов нет - сразу возвращаем экземпляр класса
			if($constructArguments === []){
				return new $class();
			}
			
			// Перебираем все аргументы конструктора, собираем их значения
			$args = [];
			foreach($constructArguments as $argument){
				// Получаем тип аргумента
				// Можно получить сразу имя класса -  $argument->getName()
				// но так оно будет без учета его namespace, а нам нужно с учетом namespace
				// поэтому получаем полное имя класса через тип аргумента
				$argumentType = $argument->getType()->getName();
				
				// Получаем сам аргумент по его типу из контейнера
				// В оригинале так $args[$argument->getName()],
				// но это приводит к Fatal error в (...$args) - Cannot unpack array with string key
				// Так работает только с php 8.0.0
				$args[] = $this->get($argumentType); // рекурсия
			}
			
			// И возвращаем экземпляр класса со всеми зависимостями
			return new $class(...$args);
		}
	}