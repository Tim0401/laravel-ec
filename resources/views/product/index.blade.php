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

        <p>
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              検索条件
            </button>
        </p>
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <form method="GET" action="{{ route('product.index') }}">
                    <label for="base" class="form-label">フリーワード</label>
                    <div class="input-group mb-3">
                        <input type="text" name="base" class="form-control" id="base" value="{{ Request::get('base') }}">
                    </div>

                    <label class="form-label">タグ</label>
                    <div class="input-group mb-3">
                        @foreach ($tags as $tag)
                            <div class="form-check form-check-inline">
                                <input name="tags[]" class="form-check-input" type="checkbox" id="tag_{{ $tag->id }}" value="{{ $tag->id }}" {{ in_array($tag->id, Request::get('tags') ? Request::get('tags') : []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                            </div>
                        @endforeach
                    </div>

                    <label for="sort" class="form-label">並び順</label>
                    <div class="input-group mb-3">
                        <select name="sort" class="form-select" id="sort">
                            @foreach (ProductConst::SORT_LIST as $name => $value)
                                <option value="{{ $value }}" {{ Request::get('sort') === $value ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <select name="order" class="form-select" id="order">
                            @foreach (ProductConst::ORDER_LIST as $name => $value)
                                <option value="{{ $value }}" {{ Request::get('order') === $value ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-success">検索</button>
                </form>
            </div>
        </div>

        <div class="row row-cols-4 mt-2">
            @foreach ($products as $product)
                <div class="col mb-2">
                    <div class="card">
                        <img src="{{ $product->image_path }}" class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">{{ $product->name }}</h5>
                          @foreach ($product->tags as $tag)
                            <h6 class="card-subtitle mb-2 text-muted inline">{{ $tag->name }}</h6>
                          @endforeach
                          <p class="card-text">{{ $product->description }}</p>
                          <a href="{{ route('product.show', ['id' => $product->id]) }}" class="btn btn-primary">詳細</a>
                        </div>
                        <div class="card-footer text-muted">
                            ¥{{ number_format($product->price) }}
                            在庫：{{ number_format($product->stock) }}
                        </div>
                      </div>
                </div>
            @endforeach
        </div>
        {{ $products->links() }}
    </div>
</x-app-layout>
