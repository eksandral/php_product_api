<?php

namespace Eksandral\ProductsApi;

class Server {
protected array $products;
protected array $discounts;
protected array $responseData = [];

    public function __construct()
    {
        $this->loadData();
    }
    public function run(): void{
        $this->handleRequest();
        $this->sendResponse();

    }
    protected function loadData(): void{

        $content = file_get_contents("data/products.json");
        $data = json_decode($content,true);
        $products = [];
        foreach ($data as $row){
            $products[] = Product::fromArray($row);
        }
        $content = file_get_contents("data/discounts.json");
        $data = json_decode($content,true);
        $discounts = [];
        foreach ($data as $row){
            $discounts[] = Discount::fromArray($row);
        }
        $this->products = $products;
        $this->discounts = $discounts;
    }
    protected function handleRequest(): void{
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if ($requestMethod !== "GET"){
            http_response_code(404);
            return;
        }
        $url = parse_url($_SERVER['REQUEST_URI']);
        if($url["path"]!=="/products"){
            http_response_code(404);
            return;
        } 
        http_response_code(200);
        $query = [];
        parse_str($url["query"], $query);
        $filter = Filter::fromArray($query);
        $products =  $this->getProducts($filter); 
        
        $outputProducts = [];
        foreach ($products as $row){
            $price = Price::fromDiscountsAndProduct($this->discounts, $row);
            $outputProducts[] = [
                "name"=>$row->name,
                "sku"=>$row->sku,
                "category"=> $row->category,
                "price"=>$price

            ];
        }
        $this->responseData = ["products"=>$outputProducts,"pagination"=>[
            "page"=>$filter->page,
            "page_size"=>$filter->page_size
        ]];
    }
    protected function sendResponse(): void{
        header('Content-Type: application/json');
        echo json_encode($this->responseData);
    }
    protected function getProducts(Filter $filter): array{
        $filtered = [];
        foreach($this->products as $row){
            if($filter->category == "" || $filter->category !== $row->category) {
                continue;
            }
            if ($filter->priceLessThan > 0 && $row->price > $filter->priceLessThan){
                continue;
            }
            $filtered[] = $row;
        }
        $pages = (int) (count($filtered)/$filter->page_size) +1;
        $page = $filter->page>$pages ? 1: $filter->page;
        $offset = ($page-1)*$filter->page_size;

        return array_slice($filtered, $offset, $filter->page_size,false);
    }
}
