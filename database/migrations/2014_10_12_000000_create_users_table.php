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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('uuid()'));
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('genero',['M','F'])->default('M');
            $table->date('data_nascimento');
            $table->string('bilhete_identidade');
            $table->boolean('is_validado')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('perfil')->nullable();
            $table->string('image')->nullable();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
