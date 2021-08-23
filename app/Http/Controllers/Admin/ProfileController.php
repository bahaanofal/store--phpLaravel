<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Profile $profile)
    {
        // SELECT * FROM ratings WHERE rateable_id = ? AND rateable_type = 'App\Model\Profile'
        return $profile->ratings;

        // $user = User::find($profile->user_id);
        // return $user->load('profile');
    }
}
