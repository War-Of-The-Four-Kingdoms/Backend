<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAvatarController extends Controller
{
    public function getUserWithAvatar()
    {
        $user = Auth::user();
        $user->avatar = Avatar
        return response()->json(['success' => $user], $this->successStatus);
    }

}
