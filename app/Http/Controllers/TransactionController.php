<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Exceptions\TransactionException;
use App\Http\Requests\TransactionRequest;
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
     * @OA\Post(
     *      path="/api/v1/transactions",
     *      operationId="storeTransaction",
     *      tags={"Transactions"},
     *      summary="Store new transaction",
     *      description="Confirmation message",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TransactionRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error"
     *      )
     * )
     */

    /**
     * Create a new transaction.
     *
     * @param  TransactionRequest
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        try {
            return new JsonResponse([
                'created' => $this->transactionService->performTransaction($request->all())
            ],201);
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
        }
        return new JsonResponse([
            'error' => 'Ocorreu um erro interno no servidor'
        ], 500);
    }

}
