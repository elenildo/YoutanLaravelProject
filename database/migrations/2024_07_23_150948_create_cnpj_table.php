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
        Schema::create('cnpj', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj', 18)->unique();
            $table->string('filial', 100);
            $table->boolean('ativo', true);
            $table->timestamps();
            $table->unsignedBigInteger('cliente_id');

            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cnpj');
    }
};
