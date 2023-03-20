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
        Schema::create('calendario_prova', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('uuid()'));
            $table->foreignUuid('calendario_id')->constrained('calendarios');
            $table->foreignUuid('prova_id')->constrained('provas');
            $table->date('data');
            $table->time('hora_comeco');
            $table->time('hora_fim');
            $table->uuid('created_by');
            $table->uuid('updated_by');
            $table->timestamps();
            $table->unique(['calendario_id','prova_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendario_provas');
    }
};
