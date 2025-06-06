<?php
namespace App\Http\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginRepository
{
    
    public function logon(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',

        ], [
            'email.required' => 'Informe seu email',
            'password.required' => 'Informe sua senha',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        } 
            
            return redirect()->route('login')
                ->with("error", "Credenciais inválidas, tente novamente");
        
        
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Você saiu do sistema !');

    }


}
