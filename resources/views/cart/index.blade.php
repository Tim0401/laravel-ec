<x-app-layout>
    <div class="container mt-2">
        カート
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('cart.update') }}">
            <div class="row row-cols-4 mt-2">
                @csrf
                @method('PUT')
                @foreach ($items as $item)
                    <div class="col mb-2">
                        <div class="card">
                            <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            @foreach ($item->associatedModel->tags as $tag)
                                <h6 class="card-subtitle mb-2 text-muted inline">{{ $tag->name }}</h6>
                            @endforeach
                            <div class="mb-3">
                                <label class="form-label">個数</label>
                                <input type="number" name="amount[{{ $item->id }}]" class="form-control" value="{{ $item->quantity }}" min="1">
                            </div>
                            <a href="{{ route('cart.delete', ['product' => $item->id]) }}" class="btn btn-danger">削除</a>
                            </div>
                            <div class="card-footer text-muted">
                                ¥{{ number_format($item->price) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="btn btn-primary">保存</button>
            <button class="btn btn-primary" formaction="{{ route('cart.buy') }}">購入</button>
        </form>
    </div>
</x-app-layout>
