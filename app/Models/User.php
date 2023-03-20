<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'genero',
        'data_nascimento',
        'bilhete_identidade',
        'is_validado',
        'perfil',
        'image',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_detalhe(){
        return $this->hasOne(UserDetalhe::class);
    }

    public function alunos(){
        return $this->hasOne(Aluno::class);
    }

    public function professors(){
        return $this->hasOne(Professor::class);
    }
    
    public function funcionarios(){
        return $this->hasOne(Funcionario::class);
    }    

    public static function newUserWithDetailsRequired($data): User{
        $data['created_by'] = $data['updated_by'] = Auth::user()->id;
        $data['created_at'] = $data['updated_at'] = Carbon::now();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $user->user_detalhe()->create($data);
        return $user;
    }

}
