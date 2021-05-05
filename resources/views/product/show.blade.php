<x-app-layout>
    <div class="container mt-2">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="col mb-2">
            <div class="card">
                <img src="{{ $product->image_path }}" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">{{ $product->name }}</h5>
                  @foreach ($product->tags as $tag)
                    <h6 class="card-subtitle mb-2 text-muted inline">{{ $tag->name }}</h6>
                  @endforeach
                  <p class="card-text">{{ $product->description }}</p>

                  <form method="POST" action="{{ route('cart.store') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="mb-3">
                        <label for="amount" class="form-label">個数</label>
                        <input type="number" name="amount" class="form-control" id="amount" value="1" min="1">
                    </div>
                    <button class="btn btn-primary">カートに入れる</button>
                  </form>

                </div>
                <div class="card-footer text-muted">
                    ¥{{ number_format($product->price) }}
                    在庫：{{ number_format($product->stock) }}
                </div>
              </div>
        </div>

    </div>
</x-app-layout>
