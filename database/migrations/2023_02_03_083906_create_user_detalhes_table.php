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
        Schema::create('user_detalhes', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('uuid()'));
            $table->foreignUuid('user_id')->constrained('users');
            $table->string('facebook',150)->nullable();
            $table->string('instagram',150)->nullable();
            $table->string('twitter',150)->nullable();
            $table->string('linkedin',150)->nullable();
            $table->string('contacto',150)->nullable();
            $table->string('email_opt',150)->nullable();
            $table->string('descricao')->nullable();;
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->unique(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_detalhes');
    }
};
