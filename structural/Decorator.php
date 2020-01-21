<?php

namespace JOKERTHE\Structural;

/**
 * Структурный паттерн проектирования, который позволяет динамически добавлять
 * объектам новую функциональность, оборачивая их в полезные «обёртки».
 *
 * Базовый интерфейс Компонента определяет поведение, которое изменяется
 * декораторами.
 *
 */
interface Component
{
    public function operation(): string;
}

/**
 * Конкретные Компоненты предоставляют реализации поведения по умолчанию. Может
 * быть несколько вариаций этих классов.
 *
 */
class ConcreteComponent implements Component
{
    public function operation(): string
    {
        return "ConcreteComponent";
    }
}

/**
 * Базовый класс Декоратора следует тому же интерфейсу, что и другие компоненты.
 * Основная цель этого класса - определить интерфейс обёртки для всех конкретных
 * декораторов. Реализация кода обёртки по умолчанию может включать в себя поле
 * для хранения завёрнутого компонента и средства его инициализации.
 *
 */
class Decorator implements Component
{
    /**
     * @var Component
     */
    protected $component;

    public function __construct(Component $component)
    {
        $this->component = $component;
    }

    /**
     * Декоратор делегирует всю работу обёрнутому компоненту.
     *
     */
    public function operation(): string
    {
        return $this->component->operation();
    }
}

/**
 * Конкретные Декораторы вызывают обёрнутый объект и изменяют его результат
 * некоторым образом.
 *
 */
class ConcreteDecoratorA extends Decorator
{
    /**
     * Декораторы могут вызывать родительскую реализацию операции, вместо того,
     * чтобы вызвать обёрнутый объект напрямую. Такой подход упрощает расширение
     * классов декораторов.
     *
     */
    public function operation(): string
    {
        return "ConcreteDecoratorA(" . parent::operation() . ")";
    }
}

/**
 * Декораторы могут выполнять своё поведение до или после вызова обёрнутого
 * объекта.
 *
 */
class ConcreteDecoratorB extends Decorator
{
    public function operation(): string
    {
        return "ConcreteDecoratorB(" . parent::operation() . ")";
    }
}

/**
 * Тестирование паттерна 
 *
 */
function getPattern(Component $component)
{
    echo "RESULT: " . $component->operation();
}

$simple = new ConcreteComponent;
echo "Client: I've got a simple component:\n";
getPattern($simple);
echo "\n\n";

$decorator1 = new ConcreteDecoratorA($simple);
$decorator2 = new ConcreteDecoratorB($decorator1);
echo "Client: Now I've got a decorated component:\n";
getPattern($decorator2);
