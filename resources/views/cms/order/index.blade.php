<x-app-layout>
    <div class="container mt-2">
        注文一覧

        <table class="table">
            <thead>
              <tr>
                <th scope="col">注文No.</th>
                <th scope="col">注文者</th>
                <th scope="col">商品</th>
                <th scope="col">数量</th>
                <th scope="col">単価</th>
              </tr>
            </thead>
            <tbody>
                @foreach($orderDetails as $orderDetail)
                <tr>
                    <th scope="row">{{ $orderDetail->order->id }}</th>
                    <td>{{ $orderDetail->order->user->name }}</td>
                    <td>{{ $orderDetail->product->name }}</td>
                    <td>{{ $orderDetail->amount }}</td>
                    <td>{{ $orderDetail->price }}</td>
                </tr>
                @endforeach
            </tbody>
          </table>
          {{ $orderDetails->links() }}
    </div>
</x-app-layout>
