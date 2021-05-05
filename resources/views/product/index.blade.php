<x-app-layout>
    <div class="container mt-2">
        <div class="row row-cols-4">
            @foreach ($products as $product)
                <div class="col">
                    <div class="card">
                        <img src="{{ $product->image_path }}" class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">{{ $product->name }}</h5>
                          <p class="card-text">{{ $product->description }}</p>
                          <a href="{{ route('product.show', ['id' => $product->id]) }}" class="btn btn-primary">詳細</a>
                        </div>
                      </div>
                </div>
            @endforeach
        </div>
        {{ $products->links() }}
    </div>
</x-app-layout>
