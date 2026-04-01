<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;

class UsersController extends Controller
{
    public function createUsers(Request $request)
    {
        $users = Users::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => [
                'data' => $users
            ]
        ]);
    }

    public function getUsers()
    {
        $users = Users::all();
        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditampilkan',
            'data' => [
                'data' => $users
            ]
        ]);
    }

    public function getUsersById($id)
    {
        $users = Users::find($id);
        if (!$users) {
            return response()->json([
                'success' => false,
                'message' => 'user tidak ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }
}
