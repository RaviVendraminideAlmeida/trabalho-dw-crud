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
        Schema::create('carro_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('taken')->nullable(true);
            $table->timestamp('returned')->nullable(true);
            $table->text('obs');

            $table->integer('user_id')->unsigned();
            $table->integer('carro_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('carro_id')->references('id')->on('carros')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carro_user');
    }
};
