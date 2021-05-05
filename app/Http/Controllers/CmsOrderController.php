<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class CmsOrderController extends Controller
{
    public function index()
    {
        $orderDetails = OrderDetail::with(['seller', 'product', 'order.user'])->paginate(20);
        return view('cms.order.index', ['orderDetails' => $orderDetails]);
    }
}
