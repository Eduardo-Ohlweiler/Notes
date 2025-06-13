<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate(
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16'
            ],
            [
                'text_username.required'    => 'O username é obrigatório',
                'text_username.email'       => 'O username deve ser um email válido',
                'text_password.required'    => 'A senha é obrigatória',
                'text_password.min'         => 'A senha deve ter pelo menos 6 caracteres',
                'text_password.max'         => 'A senha não pode ter mais de 16 caracteres'
            ]
        );
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        $user = User::where('username', $username)
                    ->where('deleted_at', null)
                    ->first();

        //Verifica se o usuário existe
        if(!$user)
            return redirect()->back()->withInput()->with(['loginError' => 'Login ou senha incorreto']);
        
        //Verifica se a senha está correta
        if(!password_verify($password, $user->password))
            return redirect()->back()->withInput()->with(['loginError' => 'Login ou senha incorreto']);

        //Atualiza o último login do usuário
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        //Armazena o usuário na sessão
        session(['user' => ['id'        => $user->id,
                            'username'  => $user->username
                           ]
        ]);
    }

    public function logout()
    {
        //Remove o usuário da sessão
        session()->forget('user');

        //Redireciona para a página de login
        return redirect()->to('/login')->with(['logoutSuccess' => 'Logout realizado com sucesso']);
    }
}
