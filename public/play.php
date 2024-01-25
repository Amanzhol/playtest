<?php
class Product {

    public function __construct(
        public string $title = "",
        public int $price = 0,
        public bool $enabled = false)
    {}
}

$prs = [

    new Product('Robotics', 5478, true),
    new Product('Vacuum Cleaner', 7529, true),
    new Product('Storage', 4190, false),
    new Product('Constructor', 6147, false),
];

$f = array_filter($prs, function ($product) {

    return !$product->enabled;

});

$f = array_map(function ($product){

    return $product->title;

}, $prs);

var_dump($f);
