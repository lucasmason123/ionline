<?php

use App\Models\RequestForms\RequestForm;
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
        Schema::table('arq_request_forms', function (Blueprint $table) {
            $table->foreignId('establishment_id')
                ->nullable()
                ->after('contract_manager_ou_id')
                ->constrained('establishments');
        });

        $requestForms = RequestForm::withTrashed()->get();
        foreach ($requestForms as $requestForm) {
            $requestForm->establishment_id = $requestForm->contractManager->establishment_id;
            $requestForm->save();
        }

        // quitar nullable a establishment_id
        Schema::table('arq_request_forms', function (Blueprint $table) {
            // Paso 1: Eliminar la restricción de clave externa
            $table->dropForeign(['establishment_id']);
        });

        Schema::table('arq_request_forms', function (Blueprint $table) {
            // Paso 2: Modificar la columna para que sea NOT NULL
            $table->foreignId('establishment_id')->nullable(false)->change();
        });

        Schema::table('arq_request_forms', function (Blueprint $table) {
            // Paso 3: Volver a agregar la restricción de clave externa
            $table->foreign('establishment_id')->references('id')->on('establishments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arq_request_forms', function (Blueprint $table) {
            $table->dropConstrainedForeignId('establishment_id');
        });
    }
};
