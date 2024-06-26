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
        Schema::create('professor_turma', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('uuid()'));
            $table->foreignUuid('professor_id')->constrained('professors');
            $table->foreignUuid('turma_id')->constrained('turmas');
            $table->foreignUuid('disciplina_id')->constrained('disciplinas');
            $table->uuid('created_by');
            $table->uuid('updated_by');
            $table->unique(['professor_id','turma_id']);
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
        Schema::dropIfExists('professor_turma');
    }
};
