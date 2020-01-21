<?php

namespace JOKERTHE\Structural;

/**
 * Структурный паттерн, который разделяет бизнес-логику
 * или большой класс на несколько отдельных иерархий,
 * которые потом можно развивать отдельно друг от друга.
 * Абстракция устанавливает интерфейс для «управляющей» части двух иерархий
 * классов. Она содержит ссылку на объект из иерархии Реализации и делегирует
 * ему всю настоящую работу.
 *
 */
class Abstraction
{
	/**
     * @var Implementation
     */
    protected $implementation;

    public function __construct(Implementation $implementation)
    {
        $this->implementation = $implementation;
    }

    public function operation(): string
    {
        return "Abstraction: Base operation with:\n" . $this->implementation->operationImplementation();
    }
}

/**
 * Можно расширить Абстракцию без изменения классов Реализации.
 *
 */
class ExtendedAbstraction extends Abstraction
{
    public function operation(): string
    {
        return "ExtendedAbstraction: Extended operation with:\n" . $this->implementation->operationImplementation();
    }
}

/**
 * Реализация устанавливает интерфейс для всех классов реализации. Он не должен
 * соответствовать интерфейсу Абстракции. На практике оба интерфейса могут быть
 * совершенно разными. Как правило, интерфейс Реализации предоставляет только
 * примитивные операции, в то время как Абстракция определяет операции более
 * высокого уровня, основанные на этих примитивах.
 */
interface Implementation
{
    public function operationImplementation(): string;
}

/**
 * Каждая Конкретная Реализация соответствует определённой платформе и реализует
 * интерфейс Реализации с использованием API этой платформы.
 *
 */
class ConcreteImplementationA implements Implementation
{
    public function operationImplementation(): string
    {
        return "ConcreteImplementationA: Here's the result on the platform A.\n";
    }
}

class ConcreteImplementationB implements Implementation
{
    public function operationImplementation(): string
    {
        return "ConcreteImplementationB: Here's the result on the platform B.\n";
    }
}

/**
 * Тестирование паттерна 
 *
 */
function getPattern(Abstraction $abstraction)
{
	echo $abstraction->operation();
}

$implementation = new ConcreteImplementationA;
$abstraction = new Abstraction($implementation);
getPattern($abstraction);

echo "\n";

$implementation = new ConcreteImplementationB;
$abstraction = new ExtendedAbstraction($implementation);
getPattern($abstraction);