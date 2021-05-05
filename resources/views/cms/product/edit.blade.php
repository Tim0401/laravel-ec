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
            @isset($product)
            <form method="POST" action="{{ route('cms.product.update', [ 'product' => $product->id ]) }}"  enctype='multipart/form-data'>
                @method('PUT')
            @else
            <form method="POST" action="{{ route('cms.product.store') }}" enctype='multipart/form-data'>
            @endisset
            @csrf
                <label for="name" class="form-label">商品名</label>
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') ?? $product->name ?? '' }}">
                </div>
                <label for="description" class="form-label">説明</label>
                <div class="input-group mb-3">
                    <textarea class="form-control" name="description" id="description" rows="3">{{ old('description') ?? $product->description ?? '' }}</textarea>
                </div>
                <label for="price" class="form-label">価格</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">￥</span>
                    <input type="number" name="price" class="form-control" id="price" value="{{ old('price') ?? $product->price ?? 0 }}">
                </div>
                <label for="stock" class="form-label">在庫</label>
                <div class="input-group mb-3">
                    <input type="number" name="stock" class="form-control" id="stock" value="{{ old('stock') ?? $product->stock ?? 0 }}">
                </div>
                <label for="image" class="form-label">画像</label>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" accept="image/*" id="image" name="image">
                </div>

                <button class="btn btn-primary">保存</button>
            </form>
        </div>

    </div>
</x-app-layout>
