<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSpouseDetailRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SpouseDetailController extends Controller
{

    public function show(Request $request)
    {
        $spouse = $request->user()->spouseDetail;

        if (! $spouse) {
            return response()->json(['message' => 'No spouse details found.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($spouse, Response::HTTP_OK);
    }

    public function update(UpdateSpouseDetailRequest $request)
    {
        $user = $request->user();
        $profile = $user->profile;

        if (! $profile || $profile->marital_status !== 'Married') {
            return response()->json([
                'message' => 'Cannot add spouse details unless marital status is Married.'
            ], Response::HTTP_FORBIDDEN);
        }

        $user->spouseDetail()->updateOrCreate(
            ['user_id' => $user->id],
            $request->validated()
        );

        return response()->json(['message' => 'Spouse details saved successfully.'], Response::HTTP_OK);
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        if (! $user->spouseDetail) {
            return response()->json(['message' => 'No spouse details to delete.'], Response::HTTP_NOT_FOUND);
        }

        $user->spouseDetail()->delete();

        return response()->json(['message' => 'Spouse details deleted.'], Response::HTTP_OK);
    }
}

