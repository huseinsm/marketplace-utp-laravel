<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Profiles;

class ProfilesController extends Controller
{
    public function createProfiles(Request $request)
    {
        $profiles = Profiles::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil ditambahkan',
            'data' => $profiles
        ]);
    }

    public function getUsersWithProfiles()
    {
        $users = Users::with('profiles')->get();
        return response()->json([
            'success' => true,
            'message' => 'User berhasil diambil',
            'data' => $users
        ]);
    }

    public function getProfiles()
    {
        $profiles = Profiles::all();
        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil ditampilkan',
            'data' => [
                'data' => $profiles
            ]
        ]);
    }

    public function getProfilesById($id)
    {
        $profiles = Profiles::findOrFail($id);
        if (!$profiles) {
            return response()->json([
                'success' => false,
                'message' => 'profile tidak ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $profiles
        ]);
    }
}
