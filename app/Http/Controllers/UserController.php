<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * UserController constructor.
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->userRepository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return new UserCollection(
                $this->userRepository->findAllPaginated()
            );
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            return new UserResource(
                $this->userRepository->store($request->all())
            );
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return new UserResource(
                $this->userRepository->findById($id)
            );
        }catch (NotFoundException $n){
            return new JsonResponse([
                'error' => $n->getMessage()
            ], 404);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try {
            return new UserResource(
                $this->userRepository->store($request->all(), $user->id)
            );
        }catch (NotFoundException $n){
            return new JsonResponse([
                'error' => $n->getMessage()
            ], 404);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            return new JsonResponse([
                'removed' => $this->userRepository->delete($user->id)
            ]);
        }catch (NotFoundException $n){
            return new JsonResponse([
                'error' => $n->getMessage()
            ], 404);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }
}
