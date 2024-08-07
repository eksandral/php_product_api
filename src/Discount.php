<?php

namespace Eksandral\ProductsApi;

class Discount{
    public string $type;
    public string $predicate;
    public int $value;
    use FromArray;
    public static function getAttributes(): array{
        return ["type","predicate","value"=> fn(string $x)=>(int)$x];
    }
}
