<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('telephone', 20)->nullable();
            $table->string('image')->nullable();
            $table->dateTime('unsubscribe');
            $table->timestamps();

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::create('suscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedTinyInteger('quantity');
            $table->dateTime('unsubscribe');
            $table->timestamps();

            $table->foreign('restaurant_id')
                    ->references('id')
                    ->on('restaurants')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('restaurant_id')
                    ->references('id')
                    ->on('restaurants')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedBigInteger('user_id');
            $table->tinyText('code');
            $table->tinyText('city');
            $table->string('address')->nullable();
            $table->string('telephone')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('restaurant_id')
                    ->references('id')
                    ->on('restaurants')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::create('waiters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('branch_id');
            $table->string('telephone')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('restaurant_id')
                    ->references('id')
                    ->on('restaurants')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('branch_id')
                    ->references('id')
                    ->on('branches')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->string('reference');
            $table->timestamps();

            $table->foreign('restaurant_id')
                    ->references('id')
                    ->on('restaurants')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');
        });

        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedDouble('price', 8, 2);
            $table->unsignedMediumInteger('quality')->default(0);
            $table->boolean('available')->default(FALSE);
            $table->timestamps();

            $table->foreign('restaurant_id')
                    ->references('id')
                    ->on('restaurants')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');

            $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');
        });

        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedBigInteger('table_id');
            $table->unsignedBigInteger('waiter_id');
            $table->tinyText('code');
            $table->boolean('finished')->default(FALSE);
            $table->unsignedDouble('total', 8, 2);
            $table->timestamps();

            $table->foreign('restaurant_id')
                    ->references('id')
                    ->on('restaurants')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');

            $table->foreign('table_id')
                    ->references('id')
                    ->on('tables')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');

            $table->foreign('waiter_id')
                    ->references('id')
                    ->on('waiters')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');
        });

        Schema::create('order_dishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('dish_id');
            $table->unsignedDouble('price', 8, 2);
            $table->unsignedMediumInteger('quality');
            $table->string('note');
            $table->timestamps();

            $table->foreign('order_id')
                    ->references('id')
                    ->on('order')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('dish_id')
                    ->references('id')
                    ->on('dishes')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
        Schema::dropIfExists('suscriptions');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('waiters');
        Schema::dropIfExists('tables');
        Schema::dropIfExists('dishes');
        Schema::dropIfExists('order');
        Schema::dropIfExists('order_dishes');
    }
};
