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
        Schema::create('notas', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('uuid()'));
            $table->foreignUuid('prova_id')->constrained('provas');
            $table->foreignUuid('aluno_id')->constrained('alunos');
            $table->enum('valor',[
                '0','1','2','3','4','5','6','7','8','9','10',
                '11','12','13','14','15','16','17','18','19','20'
            ])->default('0');
            $table->uuid('created_by');
            $table->uuid('updated_by');            
            $table->timestamps();
            $table->unique(['prova_id','aluno_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notas');
    }
};
