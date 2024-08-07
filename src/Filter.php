<?php

namespace Eksandral\ProductsApi;
class Filter{
    use FromArray;
    public const UPPER_LIMIT = 50;
    public string $category;
    public int $priceLessThan = 0;
    public int $page = 1;
    public int $page_size= 5;

    public static function getAttributes(): array{
        return  ["category","priceLessThan"=>[Filter::class,"filterUint"],"page"=> [Filter::class,"filterPage"],"page_size"=>[Filter::class,"filterPage"]];
    }
    public static function filterUint(string $x): int {
        $value = (int)$x;
        return $value>=0?$value:0;
    }
    public static function filterPage(string $x): int {
        $value = (int)$x;
        return $value>0 && $value <= static::UPPER_LIMIT?$value:1;
    }
}
