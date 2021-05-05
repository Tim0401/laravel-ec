<?php

namespace App\Http\Controllers;

use App\Exceptions\StockException;
use Illuminate\Http\Request;
use App\Models\Product;
use Barryvdh\Debugbar\Facade as Debugbar;
use App\Services\OrderService;

class CartController extends Controller
{
    /**
     * ProductServiceの実装
     *
     * @var OrderService
     */
    protected $orderService;

    /**
     * 新しいコントローラインスタンスの生成
     *
     * @param  OrderService  $orderService
     * @return void
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $items = \Cart::session(auth()->user()->id)->getContent();
        Debugbar::debug($items);
        return view('cart.index', ['items' => $items]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'numeric'],
            'amount' => ['required', 'integer', 'numeric', 'min:1'],
        ]);

        /** @var \App\Models\Product $product */
        $product = Product::with('tags')->find($validated['product_id']);
        if (!$product) {
            return back()->withErrors(array('product_id' => 'product not found.'));
        }
        \Cart::session(auth()->user()->id)->add(array(
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $validated['amount'],
            'associatedModel' => $product
        ));

        return redirect()->route('cart.index');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'amount' => ['required', 'array'],
            'amount.*' => ['required', 'min:1']
        ]);
        $amounts = $validated['amount'];
        foreach ($amounts as $id => $amount) {
            \Cart::session(auth()->user()->id)->update($id, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $amount
                ),
            ));
        }

        return redirect()->route('cart.index');
    }

    public function buy(Request $request)
    {
        $validated = $request->validate([
            'amount' => ['required', 'array'],
            'amount.*' => ['required', 'min:1']
        ]);

        // 最新の情報にアップデート
        $amounts = $validated['amount'];
        foreach ($amounts as $id => $amount) {
            \Cart::session(auth()->user()->id)->update($id, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $amount
                ),
            ));
        }

        // 購入処理/在庫チェック
        $items = \Cart::session(auth()->user()->id)->getContent();
        try {
            $this->orderService->buy($items, auth()->user()->id);
        } catch (StockException $e) {
            return back()->withErrors(array('stock' => 'not enough stock.'));
        }

        // カートをクリア
        \Cart::session(auth()->user()->id)->clear();

        // 購入完了画面
        return redirect()->route('cart.finish');
    }

    public function finish()
    {
        return view('cart.finish');
    }

    public function delete($id)
    {
        \Cart::session(auth()->user()->id)->remove($id);
        return redirect()->route('cart.index');
    }
}
