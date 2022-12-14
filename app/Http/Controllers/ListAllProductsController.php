<?php

namespace App\Http\Controllers;

use App\Models\Product\Product;
use App\Models\Product\ProductRepository;

class ListAllProductsController extends Controller
{
    public function __invoke(ProductRepository $repository)
    {
        return array_map(
            fn(Product $product) => $product->toArray(),
            $repository->products()
        );
    }
}
