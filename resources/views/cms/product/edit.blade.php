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
                    <button class="btn btn-primary">保存</button>
                </div>
                <div class="card-footer text-muted">
                    ¥{{ number_format($product->price) }}
                    在庫：{{ number_format($product->stock) }}
                </div>
              </div>
        </div>

    </div>
</x-app-layout>
