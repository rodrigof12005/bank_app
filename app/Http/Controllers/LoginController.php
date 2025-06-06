<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\LoginService;

class LoginController extends Controller

{
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function logon(Request $request)
    {
        $login = $this->loginService->logon($request);
        return $login;
    }

   

    public function logout(Request $request)
    {
        $logout = $this->loginService->logout($request);
        return $logout;
    }
}
