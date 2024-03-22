<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function index()
    {
        return ProfileResource::collection(Profile::all());
    }

    public function store(ProfileRequest $request)
    {
        return new ProfileResource(Profile::create($request->validated()));
    }

    public function show(Profile $profile)
    {
        return new ProfileResource($profile);
    }

    public function update(ProfileRequest $request, Profile $profile)
    {
        $profile->update($request->validated());

        return new ProfileResource($profile);
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();

        return response()->json();
    }
}
