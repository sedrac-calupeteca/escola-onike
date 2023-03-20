<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     private function change(Request $request, $id, $key_pass = "password_up") {
        try {
            $data = $request->all();
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = Carbon::now();
            $user = User::find($id);
            if(!Hash::check($data[$key_pass], $user->password)){
                toastr()->warning("Senha inválida","Aviso");
                return redirect()->back();    
            }
            $user->update($data);
            toastr()->success("Operação de actualização foi realizada com sucesso","Successo");
        } catch (Exception) {
            toastr()->error("Operação de actualização não foi possível a sua realização","Erro");
        }
        return redirect()->back();
    }     


    public function index()
    {
        $user = User::with('user_detalhe')->find(Auth::user()->id);
        return view('home', [
            "painel" => "home",
            "auth" => $user
        ]);
    }


    public function update(Request $request, $id) {
        $request->validate([
            'password_up' => ['required'],
            'name' => ['required'],
            'email' => ['required'],
            'data_nascimento' => ['required'],
            'bilhete_identidade' => ['required', 'string', 'regex:/[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z][A-Z][0-9][0-9][0-9]/']
        ]);
        return $this->change($request, $id);    
    }

    public function password(Request $request, $id) {
        $request->validate([
            'password' => ['required'],
            'newpassword' => ['required'],
            'renewpassword' => ['required']
        ]);

        if($request->newpassword != $request->renewpassword){
            toastr()->warning("Senhas fornecidas são diferentes, por favor tente de novo","Aviso");
            return redirect()->back();    
        }

        $request['password'] = Hash::make($request->newpassword);
        
        return $this->change($request, $id, "newpassword");    
    }


}
