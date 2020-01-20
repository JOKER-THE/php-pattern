<?php

namespace JOKERTHE\Creational;

/**
 * Порождающий шаблон проектирования, гарантирующий, что в однопоточном приложении
 * будет единственный экземпляр некоторого класса, и предоставляющий глобальную 
 * точку доступа к этому экземпляру.
 * Паттерн Singleton предоставляет метод GetInstance
 */
class Singleton
{
	/**
	 * Объект класса Singleton храниться в статичном поле класса
	 *
	 */
	private static $instance = null;

	/**
	 * Защищаем от создания через new Singleton
	 *
	 */
	protected function __construct()
	{

	}

	/**
	 * Защищаем от создания через клонирование
	 *
	 */
	protected function __clone()
	{
		
	}

	/**
	 * Защищаем от создания через unserialize
	 *
	 */
	protected function __wakeup()
	{
		
	}

	/**
     * Это статический метод, управляющий доступом к экземпляру одиночки. При
     * первом запуске, он создаёт экземпляр одиночки и помещает его в
     * статическое поле. При последующих запусках, он возвращает клиенту объект,
     * хранящийся в статическом поле.
     *
     */
    public static function getInstance(): Singleton
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}

/**
 * Тестирование паттерна Singleton
 *
 */
function getPattern()
{
    $s1 = Singleton::getInstance();
    $s2 = Singleton::getInstance();

    if ($s1 === $s2) {
        echo "Singleton работает, обе переменные содержат один и тот же экземпляр.";
    } else {
        echo "Singleton не работает, переменные содержат разные экземпляры.";
    }
}

getPattern();