<?php

namespace App\Services;

use App\Consts\ProductConst;
use App\Exceptions\StockException;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderService
{
    /**
     * 検索条件の作成
     *
     * @param Darryldecode\Cart\CartCollection $items
     * @param number  $userId
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function buy($items, $userId)
    {
        $inputs = $items->keyBy('id');
        DB::transaction(function () use ($inputs, $userId) {
            // 在庫の確認と更新
            $products = Product::lockForUpdate()->find($inputs->keys());

            $orderDetails = collect();
            $price = 0;
            $products->each(function (Product &$product) use ($inputs, $orderDetails, &$price) {
                if ($product->stock < $inputs[$product->id]->quantity) {
                    throw new StockException();
                }
                $product->stock -= $inputs[$product->id]->quantity;

                $orderDetail = new OrderDetail();
                $orderDetail->product_id = $product->id;
                $orderDetail->amount = $inputs[$product->id]->quantity;
                $orderDetail->price = $product->price;
                $orderDetails->push($orderDetail);

                $price += $product->price * $inputs[$product->id]->quantity;
            });

            Product::upsert(array_map(function ($item) {
                $item['created_at'] = Carbon::parse($item['created_at'])->format('Y-m-d H:i:s');
                $item['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
                return $item;
            }, $products->toArray()), 'id');

            /** @var \App\Models\Order $order */
            $order = new Order();
            $order->user_id = $userId;
            $order->price = $price;
            $order->save();

            OrderDetail::insert(array_map(function ($item) use ($order) {
                $item['order_id'] = $order->id;
                $item['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
                $item['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
                return $item;
            }, $orderDetails->toArray()));
        });
    }
}
