<?php

namespace JOKERTHE\Behavioral;

/**
 * Поведенческий паттерн проектирования, который позволяет добавлять в программу
 * новые операции, не изменяя классы объектов, над которыми эти операции могут выполняться.
 *
 * Интерфейс Компонента объявляет метод accept, который в качестве аргумента
 * может получать любой объект, реализующий интерфейс посетителя.
 *
 */
interface Component
{
    public function accept(Visitor $visitor): void;
}

/**
 * Каждый Конкретный Компонент должен реализовать метод accept таким образом,
 * чтобы он вызывал метод посетителя, соответствующий классу компонента.
 *
 */
class ConcreteComponentA implements Component
{
    /**
     * Обратите внимание, мы вызываем visitConcreteComponentA, что соответствует
     * названию текущего класса. Таким образом мы позволяем посетителю узнать, с
     * каким классом компонента он работает.
     *
     */
    public function accept(Visitor $visitor): void
    {
        $visitor->visitConcreteComponentA($this);
    }

    /**
     * Конкретные Компоненты могут иметь особые методы, не объявленные в их
     * базовом классе или интерфейсе. Посетитель всё же может использовать эти
     * методы, поскольку он знает о конкретном классе компонента.
     *
     */
    public function exclusiveMethodOfConcreteComponentA(): string
    {
        return "A";
    }
}

class ConcreteComponentB implements Component
{
    /**
     * То же самое здесь: visitConcreteComponentB => ConcreteComponentB
     *
     */
    public function accept(Visitor $visitor): void
    {
        $visitor->visitConcreteComponentB($this);
    }

    public function specialMethodOfConcreteComponentB(): string
    {
        return "B";
    }
}

/**
 * Интерфейс Посетителя объявляет набор методов посещения, соответствующих
 * классам компонентов. Сигнатура метода посещения позволяет посетителю
 * определить конкретный класс компонента, с которым он имеет дело.
 *
 */
interface Visitor
{
    public function visitConcreteComponentA(ConcreteComponentA $element): void;

    public function visitConcreteComponentB(ConcreteComponentB $element): void;
}

/**
 * Конкретные Посетители реализуют несколько версий одного и того же алгоритма,
 * которые могут работать со всеми классами конкретных компонентов.
 *
 */
class ConcreteVisitor1 implements Visitor
{
    public function visitConcreteComponentA(ConcreteComponentA $element): void
    {
        echo $element->exclusiveMethodOfConcreteComponentA() . " + ConcreteVisitor1\n";
    }

    public function visitConcreteComponentB(ConcreteComponentB $element): void
    {
        echo $element->specialMethodOfConcreteComponentB() . " + ConcreteVisitor1\n";
    }
}

class ConcreteVisitor2 implements Visitor
{
    public function visitConcreteComponentA(ConcreteComponentA $element): void
    {
        echo $element->exclusiveMethodOfConcreteComponentA() . " + ConcreteVisitor2\n";
    }

    public function visitConcreteComponentB(ConcreteComponentB $element): void
    {
        echo $element->specialMethodOfConcreteComponentB() . " + ConcreteVisitor2\n";
    }
}

/**
 * Тестирование паттерна 
 *
 */
function getPattern(array $components, Visitor $visitor)
{
    foreach ($components as $component) {
        $component->accept($visitor);
    }
}

$components = [
    new ConcreteComponentA,
    new ConcreteComponentB
];

echo "The client code works with all visitors via the base Visitor interface:\n";
$visitor1 = new ConcreteVisitor1;
getPattern($components, $visitor1);
echo "\n";

echo "It allows the same client code to work with different types of visitors:\n";
$visitor2 = new ConcreteVisitor2;
getPattern($components, $visitor2);