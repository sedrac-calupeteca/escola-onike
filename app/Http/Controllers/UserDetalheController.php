<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetalhe;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDetalheController extends Controller
{
    public function update(Request $request, $id){
        try{
            $request->validate(['contacto' => 'required','email_opt' => 'required']);
            $user = User::with('user_detalhe')->find($id);
            $data = $request->all();
            $data['user_id'] =  $id;
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = Carbon::now();
            if(!isset($user->user_detalhe)){
                $data['created_by'] = Auth::user()->id;
                $data['created_at'] = Carbon::now();    
                UserDetalhe::create($data);
                toastr()->success("Operação de criado foi realizada com sucesso","Successo");
            }else{
                $user->user_detalhe->update($data);
                toastr()->success("Operação de actualização foi realizada com sucesso","Successo");
            }
        }catch(Exception $e){
            toastr()->error("Operação de actualização não foi possível a sua realização","Erro");
        }
        return redirect()->back();
    }

}
