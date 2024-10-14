<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HostController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'terms' => 'required|accepted'
        ]);

        $user = Auth::user();
        $user->is_host = true;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully'
        ], 200);
    }

    // public function approve(Request $request)
    // {
    //     $user = User::find($request->user_id);
    //     $user->is_host = true;
    //     $user->save();

    //     return response()->json([
    //         'message' => 'Application approved successfully'
    //     ]);
    // }

    // public function reject(Request $request)
    // {
    //     $user = User::find($request->user_id);
    //     $user->is_host = false;
    //     $user->save();

    //     return response()->json([
    //         'message' => 'Application rejected successfully'
    //     ]);
    // }
}
