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
        Schema::create('cursos', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('uuid()'));
            $table->string('nome')->unique();
            $table->enum('nivel',['PRIMARIO','SECUNDARIO','TECNICO','MEDIO'])->default('SECUNDARIO');
            $table->enum('num_classe',['7','8','9','10','11','12','13']);
            $table->string('descricao')->nullable();
            $table->boolean('is_fechado')->default(false);
            $table->uuid('created_by');
            $table->uuid('updated_by');
            $table->timestamps();
            $table->unique(['num_classe','nome']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos');
    }
};
