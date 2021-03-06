<?php

namespace App\Services;

use App\Consts\ProductConst;
use App\Models\Product;
use App\Models\ProductTag;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductService
{
    /**
     * 検索条件の作成
     *
     * @param string $base
     * @param array  $tags
     * @param string $sort
     * @param string $order
     * @param number|null   $sellerId
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function search($base = '', $tags = [], $sort = 'created_at', $order = 'desc', $sellerId = null)
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $query = Product::with('tags');

        // 販売者で検索
        if ($sellerId) {
            $query->where('seller_id', $sellerId);
        }

        // タグ検索
        if (!empty($tags)) {
            $query->whereHas(
                'productTags',
                function ($query) use ($tags) {
                    $query->whereIn('tag_id', $tags);
                }
            );
        }

        // 全文検索
        if (!empty($base)) {
            $searchWord = "+" . $base;
            $searchWord = str_replace(" ", " +", $searchWord);
            $query->whereRaw("match (name,description) against (? IN BOOLEAN MODE)", $searchWord);
        }

        // 並び順
        $query->orderBy($sort, $order);

        return $query;
    }

    /**
     * 商品画像の保存
     *
     * @param \Illuminate\Http\UploadedFile $file
     *
     * @return string ファイルパス
     */
    public function uploadImage($file)
    {
        $imagePath = $file->store('public/products');
        // TODO: 変換にGDライブラリ必須な為コメントアウト
        // $image = Image::make(Storage::get($imagePath))->resize(
        //     1024,
        //     null,
        //     function ($constraint) {
        //         $constraint->aspectRatio();
        //         $constraint->upsize();
        //     }
        // )->encode('jpg', 50);
        // Storage::put($imagePath, $image);
        return Storage::url($imagePath);
    }

    /**
     * 商品保存
     *
     * @param Product|null $product
     * @param array $data
     * @param string|null $imagePath
     *
     * @return number
     */
    public function save($product, $data, $imagePath = null)
    {
        if (!$product) {
            $product = new Product();
            $product->seller_id = auth()->user()->id;
        }
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->stock = $data['stock'];
        if ($imagePath) {
            $product->image_path = $imagePath;
        }
        $tags = [];
        if (!empty($data['tags'])) {
            $tags = $data['tags'];
        }
        DB::transaction(function () use ($product, $tags) {
            $product->save();
            $product->tags()->sync($tags);
        });

        return $product->id;
    }
}
