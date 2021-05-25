<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\AccountRequest;
use App\Http\Resources\AccountCollection;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\Models\User;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Services\AccountService;
use App\Services\Contracts\AccountServiceInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class AccountController
 * @package App\Http\Controllers
 */
class AccountController extends Controller
{

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Finance Challenge API",
     *      description="Api to perfirm financial transfers between user accounts",
     *      @OA\Contact(
     *          email="contato.leandrogoncalves@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url="http://localhost:8081",
     *      description="API Server"
     * )

     *
     * @OA\Tag(
     *     name="Accounts",
     *     description="API Endpoints of Accounts"
     * )
     */


    /**
     * @var AccountServiceInterface
     */
    protected $accountService;

    /**
     * AccountController constructor.
     * @param AccountRepositoryInterface $repository
     */
    public function __construct(AccountServiceInterface $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/accounts",
     *      operationId="getAccountsList",
     *      tags={"Accounts"},
     *      summary="Get list of accounts",
     *      description="Returns list of accounts",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/AccountCollection")
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="Error"
     *      )
     *   )
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return new AccountCollection(
                $this->accountService->findAllPaginated()
            );
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return new JsonResponse([
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/accounts",
     *      operationId="storeAccount",
     *      tags={"Accounts"},
     *      summary="Store new user",
     *      description="Returns user data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AccountRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Account")
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="Error"
     *      )
     * )
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\AccountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountRequest $request)
    {
        try {
            return new AccountResource(
                $this->accountService->store($request->all())
            );
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return new JsonResponse([
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/accounts/{id}",
     *      operationId="getAccountById",
     *      tags={"Accounts"},
     *      summary="Get user information",
     *      description="Returns user data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Account id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Account")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error"
     *      )
     * )
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return new AccountResource(
                $this->accountService->findById($id)
            );
        }catch (NotFoundException $n){
            return new JsonResponse([
                'error' => $n->getMessage()
            ], 404);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return new JsonResponse([
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/v1/accounts/{id}",
     *      operationId="updateAccounts",
     *      tags={"Accounts"},
     *      summary="Update existing user",
     *      description="Returns updated user data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Accounts id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AccountRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Account")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error"
     *      )
     * )
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            return new AccountResource(
                $this->accountService->store($request->all(), $id)
            );
        }catch (NotFoundException $n){
            return new JsonResponse([
                'error' => $n->getMessage()
            ], 404);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return new JsonResponse([
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }


    /**
     * @OA\Delete(
     *      path="/api/v1/accounts/{id}",
     *      operationId="deleteAccount",
     *      tags={"Accounts"},
     *      summary="Delete existing user",
     *      description="Deletes a record and returns content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Account id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error"
     *      )
     * )
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            return new JsonResponse([
                'removed' => $this->accountService->delete($id)
            ]);
        }catch (NotFoundException $n){
            return new JsonResponse([
                'error' => $n->getMessage()
            ], 404);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return new JsonResponse([
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }
}
