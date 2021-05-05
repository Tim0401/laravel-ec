<?php

namespace App\Services;

use App\Consts\ProductConst;
use App\Models\Product;
use Barryvdh\Debugbar\Facade as Debugbar;

use function PHPUnit\Framework\isEmpty;

class ProductService
{
    public function search($base = '', $tags = [], $sort = 'created_at', $order = 'desc')
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $query = Product::with('tags');

        // タグ検索
        if (!empty($tags)) {
            $query->whereHas(
                'tags',
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
}
