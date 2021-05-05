# laravel-ec

## 環境

```
laravel 8
MariaDB 10.6
```

laravel-sailを使用。  
windowsの場合、WSL2上でのDockerビルドが必須。  
```
https://laravel.com/docs/8.x/sail
docker-compose up -d
```


## login

### User

```
http://localhost/login
user@example.com:password
```

### CMS

```
http://localhost/cms/login
cms@example.com:password
```

## todo

* Queryを見ながらdbindexの見直し
### User

* 購入履歴表示
* 商品のお気に入り/コメント/レビュー

### CMS

* 商品評価統計・閲覧数・売り上げレポート(リッチなUIで)
