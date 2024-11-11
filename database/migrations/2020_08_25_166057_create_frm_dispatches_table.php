<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrmDispatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frm_dispatches', function (Blueprint $table) {

          $table->id();
          $table->dateTime('date'); //fecha xfecha
          $table->foreignId('pharmacy_id')->nullable()->constrained('frm_pharmacies'); //origen
          $table->foreignId('establishment_id')->nullable()->constrained('frm_establishments');
          $table->longText('notes')->nullable(); //notas
          $table->foreignId('user_id')->constrained('users');
          $table->foreignId('receiver_id')->nullable()->constrained('users');
          $table->boolean('sendC19')->default(0);

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
        Schema::dropIfExists('frm_dispatches');
    }
}
