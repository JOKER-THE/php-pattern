<?php

namespace JOKERTHE\Creational;

/**
 * Класс Creator объявляет фабричный метод, который должен возвращать объект
 * класса Product. Подклассы Creator обычно предоставляют реализацию этого
 * метода.
 *
 */
abstract class Creator
{
	/**
     * Creator может также обеспечить реализацию
     * фабричного метода по умолчанию.
     *
     */
    abstract public function factoryMethod(): Product;

    /**
     * Несмотря на название, основная обязанность Creator
     * не заключается в создании продуктов. Обычно он содержит некоторую базовую
     * бизнес-логику, которая основана на объектах Product, возвращаемых
     * фабричным методом. Подклассы могут косвенно изменять эту бизнес-логику,
     * переопределяя фабричный метод и возвращая из него другой тип продукта.
     *
     */
    public function someOperation(): string
    {
        $product = $this->factoryMethod();
        $result = "Creator: тот же код Creator только что работал с " . $product->operation();

        return $result;
    }
}

/**
 * Конкретные Creator переопределяют фабричный метод для того, чтобы изменить
 * тип результирующего продукта.
 *
 */
class ConcreteCreator1 extends Creator
{
    /**
     * Сигнатура метода по-прежнему использует тип абстрактного 
     * продукта, хотя фактически из метода возвращается конкретный
     * продукт. Таким образом, Creator может оставаться независимым от
     * конкретных классов продуктов.
     *
     */
    public function factoryMethod(): Product
    {
        return new ConcreteProduct1;
    }
}

class ConcreteCreator2 extends Creator
{
    public function factoryMethod(): Product
    {
        return new ConcreteProduct2;
    }
}

/**
 * Интерфейс Product объявляет операции, которые должны выполнять все
 * конкретные продукты.
 *
 */
interface Product
{
    public function operation(): string;
}

/**
 * Конкретные Product предоставляют различные реализации интерфейса Product.
 *
 */
class ConcreteProduct1 implements Product
{
    public function operation(): string
    {
        return "{Result of the ConcreteProduct1}";
    }
}

class ConcreteProduct2 implements Product
{
    public function operation(): string
    {
        return "{Result of the ConcreteProduct2}";
    }
}

/**
 * Тестирование паттерна Factory Method
 *
 */
function getPattern(Creator $creator)
{
	echo "Client: Я не знаю класс Creator, но он все еще работает. \n" . $creator->someOperation();
}

/**
 * Приложение выбирает тип Creator в зависимости от конфигурации или среды.
 *
 */
echo "App: Launched with the ConcreteCreator1.\n";
getPattern(new ConcreteCreator1);
echo "\n\n";

echo "App: Launched with the ConcreteCreator2.\n";
getPattern(new ConcreteCreator2);