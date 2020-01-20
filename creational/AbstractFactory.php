<?php

namespace JOKERTHE\Creational;

/**
 * Порождающий паттерн проектирования, который позволяет
 * создавать семейства связанных объектов, не привязываясь
 * к конкретным классам создаваемых объектов.
 * Интерфейс Абстрактной Фабрики объявляет набор методов, которые возвращают
 * различные абстрактные продукты. Эти продукты называются семейством и связаны
 * темой или концепцией высокого уровня. Продукты одного семейства обычно могут
 * взаимодействовать между собой. Семейство продуктов может иметь несколько
 * вариаций, но продукты одной вариации несовместимы с продуктами другой.
 *
 */
interface AbstractFactory
{
    public function createProductA(): AbstractProductA;

    public function createProductB(): AbstractProductB;
}

/**
 * Конкретная Фабрика производит семейство продуктов одной вариации. Фабрика
 * гарантирует совместимость полученных продуктов. 
 *
 */
class ConcreteFactory1 implements AbstractFactory
{
    public function createProductA(): AbstractProductA
    {
        return new ConcreteProductA1;
    }

    public function createProductB(): AbstractProductB
    {
        return new ConcreteProductB1;
    }
}

class ConcreteFactory2 implements AbstractFactory
{
    public function createProductA(): AbstractProductA
    {
        return new ConcreteProductA2;
    }

    public function createProductB(): AbstractProductB
    {
        return new ConcreteProductB2;
    }
}

/**
 * Каждый отдельный продукт семейства продуктов должен иметь базовый интерфейс.
 * Все вариации продукта должны реализовывать этот интерфейс.
 *
 */
interface AbstractProductA
{
    public function usefulFunctionA(): string;
}

/**
 * Конкретные продукты создаются соответствующими Конкретными Фабриками.
 *
 */
class ConcreteProductA1 implements AbstractProductA
{
    public function usefulFunctionA(): string
    {
        return "The result of the product A1.";
    }
}

class ConcreteProductA2 implements AbstractProductA
{
    public function usefulFunctionA(): string
    {
        return "The result of the product A2.";
    }
}

/**
 * Базовый интерфейс другого продукта. Все продукты могут взаимодействовать друг
 * с другом, но правильное взаимодействие возможно только между продуктами одной
 * и той же конкретной вариации.
 *
 */
interface AbstractProductB
{
    /**
     * Продукт B способен работать самостоятельно...
     *
     */
    public function usefulFunctionB(): string;

    /**
     * ...а также взаимодействовать с Продуктами Б той же вариации.
     *
     * Абстрактная Фабрика гарантирует, что все продукты, которые она создает,
     * имеют одинаковую вариацию и, следовательно, совместимы.
     */
    public function anotherUsefulFunctionB(AbstractProductA $collaborator): string;
}

/**
 * Конкретные Продукты создаются соответствующими Конкретными Фабриками.
 *
 */
class ConcreteProductB1 implements AbstractProductB
{
    public function usefulFunctionB(): string
    {
        return "The result of the product B1.";
    }

    /**
     * Продукт B1 может корректно работать только с Продуктом A1. Тем не менее,
     * он принимает любой экземпляр Абстрактного Продукта А в качестве
     * аргумента.
     *
     */
    public function anotherUsefulFunctionB(AbstractProductA $collaborator): string
    {
        $result = $collaborator->usefulFunctionA();

        return "The result of the B1 collaborating with the ({$result})";
    }
}

class ConcreteProductB2 implements AbstractProductB
{
    public function usefulFunctionB(): string
    {
        return "The result of the product B2.";
    }

    /**
     * Продукт B2 может корректно работать только с Продуктом A2. Тем не менее,
     * он принимает любой экземпляр Абстрактного Продукта А в качестве
     * аргумента.
     */
    public function anotherUsefulFunctionB(AbstractProductA $collaborator): string
    {
        $result = $collaborator->usefulFunctionA();

        return "The result of the B2 collaborating with the ({$result})";
    }
}

/**
 * Тестирование паттерна 
 *
 */
function getPattern(AbstractFactory $factory)
{
	$productA = $factory->createProductA();
    $productB = $factory->createProductB();

    echo $productB->usefulFunctionB() . "\n";
    echo $productB->anotherUsefulFunctionB($productA) . "\n";
}

echo "Client: Testing client code with the first factory type:\n";
getPattern(new ConcreteFactory1);

echo "\n";

echo "Client: Testing the same client code with the second factory type:\n";
getPattern(new ConcreteFactory2);