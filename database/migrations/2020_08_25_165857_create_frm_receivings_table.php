<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrmReceivingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_receivings', function (Blueprint $table) {

            $table->id();
            $table->dateTime('date'); //fecha xfecha
            $table->foreignId('destiny_id')->nullable()->constrained('frm_destines'); //origen
            $table->foreignId('pharmacy_id')->nullable()->constrained('frm_pharmacies'); //destino
            $table->longText('notes')->nullable(); //notas
            $table->foreignId('inventory_adjustment_id')->nullable()->constrained('frm_inventory_adjustments');
            $table->text('order_number')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');

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
        Schema::dropIfExists('frm_receivings');
    }
}
