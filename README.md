# laravel-ec

## 環境

```
PHP 7.4
laravel 8
MariaDB 10.6
```

laravel-sailを使用。  
windowsの場合、WSL2上でのDockerビルドが必須。  
```
https://laravel.com/docs/8.x/sail
docker-compose up -d
```

## db migrate

migrate+seed
```
php -d memory_limit=-1 artisan migrate:fresh --seed
```

Seeder個別実行  
```
php artisan db:seed --class=AuthTableSeeder
php artisan db:seed --class=ProductTableSeeder
php artisan db:seed --class=OrderTableSeeder
```

## Routing

### User

Login  
```
http://localhost/login
user@example.com:password
```

マイページ(仮)  
```
http://localhost/dashboard
```

商品一覧  
```
http://localhost/product
```

カート  
```
http://localhost/cart
```

### CMS

Login  
```
http://localhost/cms/login
cms@example.com:password
```


マイページ(仮)  
```
http://localhost/cms/dashboard
```

出品商品一覧  
```
http://localhost/cms/product
```

注文一覧  
```
http://localhost/cms/order
```

## todo

* mysql 接続ユーザー変更(laravelユーザーに変更)
* メール送信周り(mailtrap)

* タグ検索の高速化
* laravel クエリキャッシュ(ほぼ検索結果の表示になるので取れるところが少なそう)
* laravel キャッシュ/セッションドライバ変更(要redis)
### User

* 購入履歴表示
* 購入後メール送信
* 商品のお気に入り/コメント/レビュー

### CMS

* 商品評価統計・閲覧数・売り上げレポート(リッチなUIで)
