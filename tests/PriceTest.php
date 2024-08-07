<?php declare(strict_types=1);
use Eksandral\ProductsApi\Discount;
use Eksandral\ProductsApi\Price;
use Eksandral\ProductsApi\Product;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class PriceTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testFromDiscountsAndProduct(array $ds, Product $p, Price $expectedResult): void
    {
        $result = Price::fromDiscountsAndProduct($ds, $p);
        $this->assertEquals($result, $expectedResult);
    }
    public static function dataProvider(): array {
        return [
            [
                [],
                Product::fromArray(["sku"=>"1", "name"=>"a product","category"=>"boots","price"=>100]), 
                Price::fromArray(["original"=>"100","finalPrice"=>"100"])
            ],
            [
                [Discount::fromArray(["type"=>"category","predicate"=>"pants","value"=>"25"])],
                Product::fromArray(["sku"=>"1", "name"=>"a product","category"=>"boots","price"=>100]), 
                Price::fromArray(["original"=>"100","finalPrice"=>"100"])
            ],
            [
                [Discount::fromArray(["type"=>"category","predicate"=>"boots","value"=>"25"])],
                Product::fromArray(["sku"=>"1", "name"=>"a product","category"=>"boots","price"=>100]), 
                Price::fromArray(["original"=>"100","finalPrice"=>"75", "discount_percentage"=>"25"])
            ],
            [
                [
                    Discount::fromArray(["type"=>"category","predicate"=>"boots","value"=>"25"]),
                    Discount::fromArray(["type"=>"sku","predicate"=>"1","value"=>"50"])
                ],
                Product::fromArray(["sku"=>"1", "name"=>"a product","category"=>"boots","price"=>100]), 
                Price::fromArray(["original"=>"100","finalPrice"=>"50", "discount_percentage"=>"50", "currency"=>"EUR"])
            ],
        ];
    }
}

