<?php

namespace App\Http\Controllers;

use App\Services\ProductService;

use App\Consts\ProductConst;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facade as Debugbar;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CmsProductController extends Controller
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
        $this->authorizeResource(Product::class, 'product');
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
            return redirect('cms.product')
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
            ->search($validData['base'], $validData['tags'], $validData['sort'], $validData['order'], auth()->user()->id)
            ->paginate(10)
            ->withQueryString();

        $tags = Tag::all();

        return view('cms.product.index', [
            'products' => $products,
            'tags' => $tags,
        ]);
    }

    public function show(Product $product)
    {
        return view('cms.product.show', ['product' => $product]);
    }

    public function create()
    {
        return view('cms.product.edit', ['tags' => Tag::all()]);
    }

    public function edit(Product $product)
    {
        $product->load('tags');
        Debugbar::debug($product);
        return view('cms.product.edit', ['product' => $product, 'tags' => Tag::all()]);
    }

    public function store(StoreProductRequest $request)
    {
        $filePath = null;
        if ($request->file('image')) {
            $filePath = $request->file('image')->store('public/products');
            $filePath = '/storage/products/' . basename($filePath);
        }
        try {
            $id = $this->productService->save(null, $request->toArray(), $filePath);
            return redirect()->route('cms.product.show', ['product' => $id]);
        } catch (Exception $e) {
            return back()->withErrors(array('error' => 'store product failed.'));
        }
    }

    public function update(Product $product, StoreProductRequest $request)
    {
        $filePath = null;
        if ($request->file('image')) {
            $filePath = $request->file('image')->store('public/products');
            $filePath = '/storage/products/' . basename($filePath);
        }
        try {
            $this->productService->save($product, $request->toArray(), $filePath);
            return redirect()->route('cms.product.show', ['product' => $product->id]);
        } catch (Exception $e) {
            return back()->withErrors(array('error' => 'update product failed.'));
        }
    }
}
