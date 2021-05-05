<?php

namespace App\Consts;

class ProductConst
{
    public const SORT_CREATED_AT = 'created_at';
    // ソート条件
    public const SORT_LIST = [
        '登録日' => self::SORT_CREATED_AT,
        '商品名' => 'name',
        '価格' => 'price',
        '在庫数' => 'stock',
    ];

    public const ORDER_ASC = 'asc';
    public const ORDER_DESC = 'desc';
    // ソート順
    public const ORDER_LIST = [
        "降順" => self::ORDER_DESC,
        "昇順" => self::ORDER_ASC,
    ];
}
