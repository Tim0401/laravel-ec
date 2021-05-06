<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class CmsOrderController extends Controller
{
    public function index()
    {
        $orderDetails = OrderDetail::with(['product.seller', 'order.user'])
            ->whereHas(
                'product',
                function ($query) {
                    $query->where('seller_id', auth()->user()->id);
                }
            )
            ->paginate(20);
        return view('cms.order.index', ['orderDetails' => $orderDetails]);
    }
}
