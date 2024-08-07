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
                [ "category"=>"cat1", "priceLessThan"=>"1",  ],
                static::getFilter("cat1", 1)
            ],
            [
                [ "category"=>"cat1"  ],
                static::getFilter("cat1", 0)
            ],
            [
                [ "category"=>"cat1", "priceLessThan"=>"",  ],
                static::getFilter("cat1", 0)
            ],
            [
                [ "category"=>"cat1", "priceLessThan"=>"70",  ],
                static::getFilter("cat1", 0)
            ],
            [
                [ "category"=>"cat1", "priceLessThan"=>"-70",  ],
                static::getFilter("cat1", 0)
            ],
            [
                [ "category"=>"cat1", "priceLessThan"=>"3", "page"=>"2" ],
                static::getFilter("cat1", 3, 2)
            ],
            [
                [ "category"=>"cat1", "priceLessThan"=>"3", "page"=>"-2" ],
                static::getFilter("cat1", 3, 1)
            ],
            [
                [ "category"=>"cat1", "priceLessThan"=>"3", "page"=>"-2", "page_size"=>"2" ],
                static::getFilter("cat1", 3, 1, 2)
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

