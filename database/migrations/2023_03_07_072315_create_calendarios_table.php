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
        Schema::create('calendarios', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('uuid()'));
            $table->foreignUuid('ano_lectivo_id')->constrained('ano_lectivos');
            $table->string('codigo')->unique();
            $table->string('descricao')->nullable();
            $table->enum('simestre',['1','2','3'])->default('1');
            $table->enum('tipo',['EPOCA_1','EPOCA_2','EXAME','RECURSO'])->default('EPOCA_1');
            $table->boolean('is_terminado')->default(false);
            $table->date('data_inicio');
            $table->date('data_fim');
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
        Schema::dropIfExists('calendarios');
    }
};
