<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBasicProfileRequest;
use App\Http\Requests\UpdateAdditionalProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function showBasic(Request $request)
    {
        try {
            $profile = $request->user()->profile;

            if (! $profile) {
                return response()->json([
                    'message' => 'Profile not found.'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'salutation' => $profile->salutation,
                'first_name' => $profile->first_name,
                'last_name' => $profile->last_name,
                'email_address' => $profile->email_address,
                'profile_image' => $profile->profile_image,
            ], Response::HTTP_OK);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving basic profile.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateBasic(UpdateBasicProfileRequest $request)
    {
        try {
            $request->user()->profile()->updateOrCreate(
                ['user_id' => $request->user()->id],
                $request->validated()
            );

            return response()->json([
                'message' => 'Basic details updated successfully.'
            ], Response::HTTP_OK);

        } catch (\Throwable $e) {
            Log::error('Failed to update basic profile: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update basic details.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function showAdditional(Request $request)
    {
        try {
            $profile = $request->user()->profile;

            if (! $profile) {
                return response()->json([
                    'message' => 'Profile not found.'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'home_address' => $profile->home_address,
                'country' => $profile->country,
                'postal_code' => $profile->postal_code,
                'dob' => $profile->dob,
                'gender' => $profile->gender,
                'marital_status' => $profile->marital_status,
            ], Response::HTTP_OK);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving additional profile details.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateAdditional(UpdateAdditionalProfileRequest $request)
    {
        try {

            if(!$request->user()->profile) {
                return response()->json([
                    'message' => 'Please create add basic details first.'
                ], Response::HTTP_NOT_FOUND);
            }

            $request->user()->profile()->updateOrCreate(
                ['user_id' => $request->user()->id],
                $request->validated()
            );

            return response()->json([
                'message' => 'Additional details updated successfully.'
            ], Response::HTTP_OK);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Failed to update additional details.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function uploadImage(Request $request)
    {
        try {

            $request->validate([
                'profile_image' => 'required|image',
            ]);

            $user = $request->user();
            $profile = $user->profile;

            if (! $profile) {
                return response()->json([
                    'message' => 'Profile not found. Please create your profile first.'
                ], Response::HTTP_NOT_FOUND);
            }

            if ($profile->profile_image && Storage::disk('public')->exists($profile->profile_image)) {
                Storage::disk('public')->delete($profile->profile_image);
            }

            $path = $request->file('profile_image')->store('profile_images', 'public');

            $profile->update(['profile_image' => $path]);

            return response()->json([
                'message' => 'Profile image uploaded successfully.',
                'image_path' => $path,
                'image_url' => Storage::url($path),
            ], Response::HTTP_OK);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Image validation failed.',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'An error occurred while uploading the profile image.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function isMarried(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile;

        if (! $profile) {
            return response()->json(['message' => 'Profile not found.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'is_married' => $profile->marital_status === 'Married'
        ], Response::HTTP_OK);
    }
    
}
