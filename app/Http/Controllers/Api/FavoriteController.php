<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FavoriteRequest;
use App\Models\Favorite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * List user's favorite channels.
     */
    public function index(Request $request): JsonResponse
    {
        $favorites = Favorite::with('channel.category')
            ->where('user_id', $request->user()->id)
            ->latest('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $favorites->map(function ($fav) {
                return [
                    'id' => $fav->id,
                    'channel' => [
                        'id' => $fav->channel->id,
                        'name' => $fav->channel->name,
                        'logo' => $fav->channel->logo,
                        'type' => $fav->channel->type,
                        'is_premium' => $fav->channel->is_premium,
                        'category' => [
                            'id' => $fav->channel->category->id,
                            'name' => $fav->channel->category->name,
                        ],
                    ],
                    'created_at' => $fav->created_at,
                ];
            }),
        ]);
    }

    /**
     * Add a channel to favorites.
     */
    public function add(FavoriteRequest $request): JsonResponse
    {
        $userId = $request->user()->id;
        $channelId = $request->channel_id;

        $exists = Favorite::where('user_id', $userId)
            ->where('channel_id', $channelId)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Channel already in favorites.',
            ], 409);
        }

        $favorite = Favorite::create([
            'user_id' => $userId,
            'channel_id' => $channelId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Channel added to favorites.',
            'data' => [
                'id' => $favorite->id,
                'channel_id' => $favorite->channel_id,
            ],
        ], 201);
    }

    /**
     * Remove a channel from favorites.
     */
    public function remove(FavoriteRequest $request): JsonResponse
    {
        $deleted = Favorite::where('user_id', $request->user()->id)
            ->where('channel_id', $request->channel_id)
            ->delete();

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Channel not found in favorites.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Channel removed from favorites.',
        ]);
    }
}
