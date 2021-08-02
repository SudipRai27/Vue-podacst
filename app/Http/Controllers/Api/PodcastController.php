<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Podcast;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PodcastStoreRequest;
use App\Http\Requests\Api\PodcastUpdateRequest;
use App\Http\Resources\Podcast\PodcastResource;

class PodcastController extends Controller
{
    public function store(PodcastStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $podcast = Podcast::create([
                'title' => $data['title'],
                'body' => $data['body'],
                'user_id' => $request->user()->id,
                'is_public' => $data['is_public']
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
        return response()->json(['data' => $podcast, 'message' => 'Podcast stored successfully'], 200);
    }

    public function index(Request $request)
    {
        $podcasts = $request->user()->podcasts()->orderBy('created_at', 'DESC')->paginate(2);
        return PodcastResource::collection($podcasts)
            ->additional(['message' => 'Podcast lists'])
            ->response()
            ->setStatusCode(200);
    }

    public function show(Podcast $podcast)
    {
        return (new PodcastResource($podcast))
            ->additional(['message' => 'Podast single item'])
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Podcast $podcast)
    {
        $podcast->delete();
        return response()->json(['data' => [], 'message' => 'Deleted successfully.'], 200);
    }

    public function update(PodcastUpdateRequest $request, Podcast $podcast)
    {
        try {
            $data = $request->validated();
            $podcast->touch();
            $podcast->update([
                'title' => $data['title'],
                'body' => $data['body'],
                'user_id' => $request->user()->id,
                'is_public' => $data['is_public']
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
        return response()->json(['data' => $podcast->refresh(), 'message' => 'Podcast updated successfully'], 200);
    }
}