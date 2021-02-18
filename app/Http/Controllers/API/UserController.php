<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Services\UsersService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private $usersService;

    /**
     * UserController constructor.
     * @param UsersService $usersService
     */
    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    /**
     * Store user
     *
     * @param UserStoreRequest $request
     * @return JsonResponse
     */
    public function store(UserStoreRequest $request)
    {
        $user = $this->usersService->store($request->validated());

        return response()->json(new UserResource($user), JsonResponse::HTTP_CREATED);
    }
}
