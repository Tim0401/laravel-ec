<?php

namespace App\Http\Controllers;

use App\Consts\ProductConst;
use App\Models\Product;
use App\Models\Tag;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * ProductServiceの実装
     *
     * @var ProductService
     */
    protected $productService;

    /**
     * 新しいコントローラインスタンスの生成
     *
     * @param  ProductService  $productService
     * @return void
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $rules = [
            'base' => [],
            'tags' => ['array'],
            'tags.*' => ['integer'],
            'sort' => [Rule::in(ProductConst::SORT_LIST)],
            'order' => [Rule::in(ProductConst::ORDER_LIST)],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('product')
                ->withErrors($validator)
                ->withInput();
        }

        $validData = $validator->validated();
        $validData['base'] = $validData['base'] ?? '';
        $validData['tags'] = $validData['tags'] ?? [];
        $validData['sort'] = $validData['sort'] ?? ProductConst::SORT_CREATED_AT;
        $validData['order'] = $validData['order'] ?? ProductConst::ORDER_DESC;

        Debugbar::debug($validData);

        $products = $this->productService
            ->search($validData['base'], $validData['tags'], $validData['sort'], $validData['order'])
            ->paginate(10)
            ->withQueryString();

        $tags = Tag::all();

        return view('product.index', [
            'products' => $products,
            'tags' => $tags,
        ]);
    }
}
