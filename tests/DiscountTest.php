<?php declare(strict_types=1);
use Eksandral\ProductsApi\Discount;
use PHPUnit\Framework\TestCase;

final class DiscountTest extends TestCase
{
    public function testFromArray(): void
    {
        $data = [
            "type"=>"sku",
            "predicate"=>"1",
            "value"=>"25"
        ];
        $result = Discount::fromArray($data);
        $expected = new Discount();
        $expected->type = "sku";
        $expected->predicate="1";
        $expected->value = 25;
        $this->assertEquals($result, $expected);
    }
}

