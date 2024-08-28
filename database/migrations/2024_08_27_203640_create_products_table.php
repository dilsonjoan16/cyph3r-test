<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->string('image');
            $table->integer('category_id')->unsigned();
            $table->boolean('status');
            $table->integer('brand_id')->unsigned();
            $table->integer('tax_rate'); // @internal: Represent as percentage.
            $table->decimal('tax_amount', 10, 2);
            $table->decimal('cost_price', 10, 2);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('brand_id')->references('id')->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
