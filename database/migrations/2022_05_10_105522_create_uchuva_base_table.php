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
            $table->unsignedBigInteger('id');
            $table->string('nit', 20);
            $table->string('telephone', 20)->nullable();
            $table->dateTime('unsubscribe');
            $table->timestamps();

            $table->primary('id');

            $table->foreign('id')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedTinyInteger('quantity');
            $table->dateTime('payment_date');
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
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('restaurant_id');
            $table->tinyText('code');
            $table->tinyText('city');
            $table->string('address')->nullable();
            $table->string('telephone')->nullable();
            $table->timestamps();

            $table->primary('id');

            $table->foreign('id')
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
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedBigInteger('branch_id');
            $table->string('telephone')->nullable();
            $table->timestamps();

            $table->primary('id');

            $table->foreign('id')
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
            $table->unsignedBigInteger('branch_id');
            $table->string('reference');
            $table->timestamps();

            $table->foreign('restaurant_id')
                    ->references('id')
                    ->on('restaurants')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');

            $table->foreign('branch_id')
                    ->references('id')
                    ->on('branches')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedDouble('price', 8, 2);
            $table->unsignedMediumInteger('quality')->default(0);
            $table->boolean('available')->nullable()->default(FALSE);
            $table->timestamps();

            $table->foreign('restaurant_id')
                    ->references('id')
                    ->on('restaurants')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');

            $table->foreign('branch_id')
                    ->references('id')
                    ->on('branches')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');

            $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedBigInteger('table_id');
            $table->unsignedBigInteger('waiter_id');
            $table->tinyText('code');
            $table->boolean('finished')->nullable();
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
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('order_id')
                    ->references('id')
                    ->on('orders')
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
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('waiters');
        Schema::dropIfExists('tables');
        Schema::dropIfExists('dishes');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_dishes');
    }
};
