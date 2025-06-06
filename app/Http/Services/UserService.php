<?php
namespace App\Http\Services;
use App\Http\Repository\UserRepository;
use Illuminate\Http\Request;

 class UserService
{
     public function __construct(UserRepository $userRepository)
     {
         $this->userRepository = $userRepository;
     }

     public function cadastrarUsuario (Request $request)
     {
        $user = $this->userRepository->cadastrarUsuario($request);
        return $user;
     }


}
