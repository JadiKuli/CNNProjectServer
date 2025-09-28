<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseContoller;
use Illuminate\Support\Facades\Request;

class UserController extends BaseContoller
{
    // Fetch User Profile
    public function fetchUserProfile()
    {
        return $this->successResponse(
            auth()->user(),
            "User profile fetched successfully.",
            200
        );
    }

    // Update User Profile
    public function updateUserProfile()
    {
        $user = auth()->user();
        $data = request()->only(['name', 'email', 'password']);

        $user->update($data);

        return $this->successResponse(
            $user,
            "User profile updated successfully.",
            200
        );
    }

    // Update Profile Picture
    public function updateProfilePicture()
    {
        $user = auth()->user();

        if (Request::hasFile('profile_picture')) {
            $file = Request::file('profile_picture');
            $path = $file->store('profile_pictures', 'public');
            $user->profile_photo_path = $path;
            $user->save();
        }

        return $this->successResponse(
            $user,
            "Profile picture updated successfully.",
            200
        );
    }

    // Delete User Account
    public function deleteUserAccount()
    {
        $user = auth()->user();
        $user->delete();

        return $this->successResponse(
            $user,
            "User account deleted successfully.",
            200
        );
    }
}
