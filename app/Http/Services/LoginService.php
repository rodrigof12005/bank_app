<?php
namespace App\Http\Services;
use App\Http\Repository\LoginRepository;
use Illuminate\Http\Request;

class LoginService
{
    public function __construct(LoginRepository $loginRepository)
    {
        $this->loginRepository = $loginRepository;
    }

    public function logon (Request $request)
    {
        $login = $this->loginRepository->logon($request);
        return $login;
    }
   

    public function logout (Request $request)
    {
        $logout = $this->loginRepository->logout($request);
        return $logout;
    }
    }
