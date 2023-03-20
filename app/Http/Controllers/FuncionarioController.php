<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FuncionarioController extends Controller
{
    public function perfil(Request $request){
        try{
            $request->validate(["perfil" => "required"]);
            $perfil = $request->get('perfil');
            switch($perfil){
                case "alunos":
                case "professors":
                case "funcionarios":
                    $user = User::find(Auth::user()->id);
                    $user->update(["perfil" => $perfil]);
                    toastr()->success("Perfil registado com sucesso","Successo");
                    return redirect()->back();
                default:
                    toastr()->warning("Perfil não aceito","Aviso");
                    return redirect()->back();
            }
           
        }catch(\Exception){
            toastr()->error("Erro na realização deste processo","Erro");
            return redirect()->back();
        }
    }

    public function foto(Request $request){
        try{
            $request->validate(["image" => "required|image","user_id" => "required" ]);

            $user = User::find($request->user_id);

            if($user->image && Storage::exists($user->image))
                Storage::delete($user->image);

            $path = $request->image->store('users');
            $user->update(["image" => $path]);

            toastr()->success("Operação realizada com sucesso","Successo");
            return redirect()->back();
        }catch(\Exception ){
            toastr()->error("Não foi possível a realização desta operação, tenta novamente","Erro");
            return redirect()->back();
        }
    }

}
