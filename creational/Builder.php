<?php

namespace JOKERTHE\Creational;

/**
 * Порождающий паттерн проектирования, который позволяет
 * создавать сложные объекты пошагово. Builder даёт возможность
 * использовать один и тот же код строительства для получения
 * разных представлений объектов.
 * Интерфейс Builder объявляет создающие методы для различных частей объектов
 * Продуктов.
 * 
 */
interface Builder
{
	public function producePartA(): void;

	public function producePartB(): void;

	public function producePartC(): void;
}

/**
 * Классы Конкретного Builder следуют интерфейсу Builder и предоставляют
 * конкретные реализации шагов построения.
 *
 */
class ConcreteBuilder implements Builder
{
    private $product;

    /**
     * Новый экземпляр Builder должен содержать пустой объект продукта,
     * который используется в дальнейшей сборке.
     *
     */
    public function __construct()
    {
        $this->reset();
    }

    public function reset(): void
    {
        $this->product = new Product;
    }

    /**
     * Все этапы производства работают с одним и тем же экземпляром продукта.
     *
     */
    public function producePartA(): void
    {
        $this->product->parts[] = "PartA1";
    }

    public function producePartB(): void
    {
        $this->product->parts[] = "PartB1";
    }

    public function producePartC(): void
    {
        $this->product->parts[] = "PartC1";
    }

    /**
     * Конкретные Builder должны предоставить свои собственные методы
     * получения результатов. Это связано с тем, что различные типы Builder
     * могут создавать совершенно разные продукты с разными интерфейсами.
     * Поэтому такие методы не могут быть объявлены в базовом интерфейсе
     * Builder.
     * Как правило, после возвращения конечного результата клиенту, экземпляр
     * Builder должен быть готов к началу производства следующего продукта.
     * Поэтому обычной практикой является вызов метода сброса в конце тела
     * метода getProduct.
     *
     */
    public function getProduct(): Product
    {
        $result = $this->product;
        $this->reset();

        return $result;
    }
}

/**
 * В отличие от других порождающих паттернов, различные конкретные Builder
 * могут производить несвязанные продукты. Другими словами, результаты различных
 * строителей могут не всегда следовать одному и тому же интерфейсу.
 *
 */
class Product
{
    public $parts = [];

    public function listParts(): void
    {
        echo "Product parts: " . implode(', ', $this->parts) . "\n\n";
    }
}

/**
 * Director отвечает только за выполнение шагов построения в определённой
 * последовательности. Это полезно при производстве продуктов в определённом
 * порядке или особой конфигурации. Строго говоря, класс Director необязателен,
 * так как клиент может напрямую управлять строителями.
 *
 */
class Director
{
    /**
     * @var Builder
     */
    private $builder;

    /**
     * Director работает с любым экземпляром строителя, который передаётся ему
     * клиентским кодом. Таким образом, клиентский код может изменить конечный
     * тип вновь собираемого продукта.
     *
     */
    public function setBuilder(Builder $builder): void
    {
        $this->builder = $builder;
    }

    /**
     * Director может строить несколько вариаций продукта, используя одинаковые
     * шаги построения.
     *
     */
    public function buildMinimalViableProduct(): void
    {
        $this->builder->producePartA();
    }

    public function buildFullFeaturedProduct(): void
    {
        $this->builder->producePartA();
        $this->builder->producePartB();
        $this->builder->producePartC();
    }
}

/**
 * Тестирование паттерна Builder
 *
 */
function getPattern(Director $director)
{
	$builder = new ConcreteBuilder;
    $director->setBuilder($builder);

    echo "Minimal Viable Product:\n";
    $director->buildMinimalViableProduct();
    $builder->getProduct()->listParts();

    echo "Full Featured Product:\n";
    $director->buildFullFeaturedProduct();
    $builder->getProduct()->listParts();
}

getPattern(new Director);