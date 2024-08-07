<?php declare(strict_types=1);
use Eksandral\ProductsApi\Filter;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class FilterTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testFromArray(array $data, $expected): void
    {
        $result = Filter::fromArray($data);
        $this->assertEquals($result, $expected);
    }

    public static function dataProvider(): array
    {
        return [
            [
                [ "category"=>"cat1", "priceLessThan"=>"80000",  ],
                static::getFilter("cat1", 80000)
            ],
            [
                [ "category"=>"cat2"  ],
                static::getFilter("cat2", 0)
            ],
            [
                [ "category"=>"cat3", "priceLessThan"=>"",  ],
                static::getFilter("cat3", 0)
            ],
            [
                [ "category"=>"cat4", "priceLessThan"=>"70",  ],
                static::getFilter("cat4", 70)
            ],
            [
                [ "category"=>"cat5", "priceLessThan"=>"-70",  ],
                static::getFilter("cat5", 0)
            ],
            [
                [ "category"=>"cat6", "priceLessThan"=>"3", "page"=>"2" ],
                static::getFilter("cat6", 3, 2)
            ],
            [
                [ "category"=>"cat7", "priceLessThan"=>"3", "page"=>"-2" ],
                static::getFilter("cat7", 3, 1)
            ],
            [
                [ "category"=>"cat8", "priceLessThan"=>"3", "page"=>"-2", "page_size"=>"2" ],
                static::getFilter("cat8", 3, 1, 2)
            ],
        ];
    }
    private static function getFilter(string $category, int $priceLessThan, int $page = 1, int $page_size = 5 ): Filter{
        $filter = new Filter();
        $filter->category = $category;
        $filter->priceLessThan= $priceLessThan;
        $filter->page = $page;
        $filter->page_size = $page_size;
        return $filter;
    }

}

