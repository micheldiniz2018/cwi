<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // GET /api/users
    public function index()
    {
        return response()->json($this->userRepository->all());
    }

    // POST /api/users
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8'
        ]);

        return response()->json(
            $this->userRepository->create($validated),
            201
        );
    }

    // GET /api/users/{id}
    public function show($id)
    {
        return response()->json($this->userRepository->find($id));
    }

    // PUT /api/users/{id}
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,'.$id,
            'password' => 'sometimes|string|min:8'
        ]);

        return response()->json(
            $this->userRepository->update($id, $validated)
        );
    }

    // DELETE /api/users/{id}
    public function destroy($id)
    {
        $this->userRepository->delete($id);
        return response()->json(null, 204);
    }
}
