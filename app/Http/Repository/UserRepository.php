<?php
namespace App\Http\Repository;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception; 

class UserRepository
{
    public function cadastrarUsuario(Request $request)
    {
        
        $cpfLimpo = preg_replace('/[^0-9]/', '', $request->input('cpf'));
        $request->merge(['cpf' => $cpfLimpo]);

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'cpf' => 'required|string|digits:11|unique:users,cpf',    
            
        ]);

        try {
            do {
                $numeroConta = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
            } while (User::where('conta', $numeroConta)->exists());

            $user = User::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'conta' => $numeroConta,
                // 'saldo' => 100.55,
                'password' => Hash::make($request->password), 
                'cpf' => $request->cpf, 
            ]);

            return redirect()->route('login')
                             ->with('success', 'Cadastro realizado com sucesso! Faça login para acessar sua conta.');

        } catch (Exception $e) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Não foi possível realizar o cadastro. Por favor, tente novamente mais tarde.');
        }
    }
}