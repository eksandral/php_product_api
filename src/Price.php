<?php

namespace Eksandral\ProductsApi;

class Price {
    use FromArray;
    public int  $original;
    public int $finalPrice;
    public ?int $discount_percentage = null;
    public string $currency="EUR";
    
    public static function getAttributes():array {
        return [
            "original"=>[Price::class,"filterUint"],
            "finalPrice"=>[Price::class,"filterUint"],
            "discount_percentage"=>[Price::class,"filterPercentage"],
            "currency" 
        ];
    }
    public static function filterUint(string $x): int {
        $value = (int) $x;
        return $value > 0 ? $value:0;
    }
    public static function filterPercentage(?string $x): ?int {
        if ($x === null) {
            return null;
        }
        return static::filterUint($x);
    }

    public static function fromDiscountsAndProduct(array $ds, Product $p): self {
        $original = $p->price;
        $discount = 0;
        foreach($ds as $d){
            $value = match (true) {
                $d->type === "category" && $d->predicate === $p->category => $d->value,
                $d->type === "sku" && $d->predicate === $p->sku => $discount = $d->value,
                default=> 0
            };
            $discount = max($discount,$value);
        }
        $finalPrice = $p->price - intval($discount*$p->price / 100);
        $instance = new self();
        $instance->original = $original;
        $instance->finalPrice = $finalPrice;
        $instance->discount_percentage = $discount>0?$discount:null;
        return $instance;

    }

    
}
