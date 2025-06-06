<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\UserService;

class UserController extends Controller
{

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function cadastrarUsuario(Request $request)
    {
        $user = $this->userService->cadastrarUsuario($request);
        return $user;
    }


}
