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
        Schema::create('fin_reception_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reception_id')->constrained('fin_receptions');

            $table->smallInteger('item_position')->nullable();

            $table->string('CodigoCategoria')->nullable();
            $table->string('Producto')->nullable();
            $table->string('Cantidad')->nullable();
            $table->string('Unidad')->nullable();
            $table->string('EspecificacionComprador')->nullable();
            $table->string('EspecificacionProveedor')->nullable();
            $table->string('PrecioNeto')->nullable();
            $table->string('TotalDescuentos')->nullable();
            $table->string('TotalCargos')->nullable();
            $table->string('Total')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fin_reception_items');
    }
};
