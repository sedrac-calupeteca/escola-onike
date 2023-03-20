<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('uuid()'));
            $table->foreignUuid('user_id')->constrained('users')->unique();
            $table->enum('funcao',[
                'DIRECTOR_GERAL',
                'DIRECTOR_PEDAGOGICO',
                'DIRECTOR_ADMINISTRATIVO',
                'TESOUREIRO',
                'COORDENADOR_TURNO',
                'SECRETARIO',
                'AUXILIAR_LIMPEZA',
                'PROTECAO_FISICA'
            ]);
            $table->uuid('created_by');
            $table->uuid('updated_by');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funcionarios');
    }
};
