<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePreferenceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PreferenceController extends Controller
{

    public function show(Request $request)
    {
        $preferences = $request->user()->preference;

        if (! $preferences) {
            return response()->json([
                'message' => 'No preferences found.'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($preferences, Response::HTTP_OK);
    }


    public function update(UpdatePreferenceRequest $request)
    {
        try {
            $user = $request->user();

            $data = [
                'hobbies' => $request->input('hobbies', []),
                'favorite_sports' => $request->input('favorite_sports', []),
                'preferred_music_genre' => $request->input('preferred_music_genre'),
                'preferred_movie_tv_show' => $request->input('preferred_movie_tv_show'),
            ];

            $user->preference()->updateOrCreate(
                ['user_id' => $user->id],
                $data
            );

            return response()->json([
                'message' => 'Preferences updated successfully.'
            ], Response::HTTP_OK);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'An error occurred while saving preferences.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

