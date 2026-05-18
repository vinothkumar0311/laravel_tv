<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveHistoryRequest;
use App\Models\WatchHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Get user's watch history.
     */
    public function index(Request $request): JsonResponse
    {
        $history = WatchHistory::with('channel.category')
            ->where('user_id', $request->user()->id)
            ->latest('updated_at')
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $history->getCollection()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'channel' => [
                        'id' => $item->channel->id,
                        'name' => $item->channel->name,
                        'logo' => $item->channel->logo,
                        'type' => $item->channel->type,
                        'category' => [
                            'id' => $item->channel->category->id,
                            'name' => $item->channel->category->name,
                        ],
                    ],
                    'last_watched_time' => $item->last_watched_time,
                    'updated_at' => $item->updated_at->toIso8601String(),
                ];
            }),
            'pagination' => [
                'current_page' => $history->currentPage(),
                'last_page' => $history->lastPage(),
                'per_page' => $history->perPage(),
                'total' => $history->total(),
            ],
        ]);
    }

    /**
     * Save/update watch history.
     */
    public function save(SaveHistoryRequest $request): JsonResponse
    {
        $history = WatchHistory::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'channel_id' => $request->channel_id,
            ],
            [
                'last_watched_time' => $request->last_watched_time ?? 0,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Watch history saved.',
            'data' => [
                'id' => $history->id,
                'channel_id' => $history->channel_id,
                'last_watched_time' => $history->last_watched_time,
            ],
        ]);
    }
}
