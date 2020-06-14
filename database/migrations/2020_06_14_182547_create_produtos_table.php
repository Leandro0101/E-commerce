<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 40);
            $table->integer('quantidade')->nullable();
            $table->unsignedBigInteger('categoria');
            $table->string('descricao', 70);
            $table->decimal('preco');
            $table->string('slug');
            $table->integer('avaliacao')->nullable();
            $table->timestamps();
            $table->foreign('categoria')->references('id')->on('categorias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
