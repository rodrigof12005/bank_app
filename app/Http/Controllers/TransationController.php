<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\TransationService;


class TransationController extends Controller
{
    /**
     * @var TransationService
     */
    private $transationService;

    public function __construct(TransationService $transationService)
    {
        $this->transationService = $transationService;
    }

    public function depositar(Request $request)
    {
        $transation = $this->transationService->depositar($request);
        return $transation;
    }
    public function transferir(Request $request)
    {
        $transation = $this->transationService->transferir($request);
        return $transation;
    }
    

}
