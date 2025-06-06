<?php
namespace App\Http\Services;
use App\Http\Repository\TransationRepository;
use Illuminate\Http\Request;

class TransationService
{
    public function __construct(TransationRepository $transationRepository)
    {
        $this->transationRepository = $transationRepository;
    }

    public function depositar (Request $request)
    {
        $transation = $this->transationRepository->depositar($request);
        return $transation;
    }
    public function transferir (Request $request)
    {
        $transation = $this->transationRepository->transferir($request);
        return $transation;
    }

    

    
    }
