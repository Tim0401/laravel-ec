<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index(['deleted_at']);
            $table->index(['deleted_at', 'price']);
            $table->index(['deleted_at', 'stock']);
            $table->index(['deleted_at', 'created_at']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->index(['deleted_at']);
        });
        Schema::table('sellers', function (Blueprint $table) {
            $table->index(['deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['deleted_at']);
            $table->dropIndex(['deleted_at', 'price']);
            $table->dropIndex(['deleted_at', 'stock']);
            $table->dropIndex(['deleted_at', 'created_at']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['deleted_at']);
        });
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropIndex(['deleted_at']);
        });
    }
}
