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
        Schema::create('turmas', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('uuid()'));
            $table->foreignUuid('curso_id')->constrained('cursos');
            $table->foreignUuid('ano_lectivo_id')->constrained('ano_lectivos');
            $table->enum('periodo',['REGULAR','NOTURNO'])->default('REGULAR');
            $table->string('sala');
            $table->uuid('created_by');
            $table->uuid('updated_by');
            $table->timestamps();
            $table->unique(['curso_id','periodo']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turmas');
    }
};
