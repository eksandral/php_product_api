<?php
namespace Eksandral\ProductsApi;
class Product {
    use FromArray;
    public string $sku;
    public string $name;
    public string $category;
    public int $price;

    public static function getAttributes(): array{
        return  ["sku","name","category","price"=>fn(string $x)=> (int)$x];
    }
}
