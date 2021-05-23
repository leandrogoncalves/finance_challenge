<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Exceptions\TransactionException;
use App\Services\Contracts\TransactionServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class TransactionController
 * @package App\Http\Controllers
 */
class TransactionController extends Controller
{

    /**
     * @var TransactionServiceInterface
     */
    protected $transactionService;

    /**
     * TransactionController constructor.
     * @param TransactionServiceInterface $service
     */
    public function __construct(TransactionServiceInterface $service)
    {
        $this->transactionService = $service;
    }

    /**
     * Create a new transaction.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            return new JsonResponse([
                'created' => $this->transactionService->performTransaction($request->all())
            ]);
        }catch (NotFoundException $n){
            return new JsonResponse([
                'error' => $n->getMessage()
            ], 404);
        }catch (TransactionException $t){
            return new JsonResponse([
               'error' => $t->getMessage()
            ],400);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

}
