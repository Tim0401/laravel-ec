<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('products', function (Blueprint $table) {
        //     $table->id();
        //     $table->string("name");
        //     $table->text("description");
        //     $table->integer('price');
        //     $table->string("image_path")->nullable();
        //     $table->integer("stock");

        //     $table->foreignId('seller_id');
        //     $table->foreign('seller_id')
        //         ->references('id')->on('sellers');

        //     $table->timestamps();
        //     $table->softDeletes();
        // });
        // Mroonga
        DB::statement('create table `products` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null, `description` text not null, `price` int not null, `image_path` varchar(255) null, `stock` int not null, `seller_id` bigint unsigned not null, `created_at` datetime null, `updated_at` datetime null, `deleted_at` datetime null) ENGINE = Mroonga COMMENT = \'engine "InnoDB" default_tokenizer "TokenMecab"\' default character set utf8mb4 collate `utf8mb4_unicode_ci`');
        DB::statement('alter table `products` add constraint `products_seller_id_foreign` foreign key (`seller_id`) references `sellers` (`id`)');
        DB::statement('ALTER TABLE products ADD FULLTEXT index (name, description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
