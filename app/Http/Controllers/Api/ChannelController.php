<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    /**
     * List channels with filtering and pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Channel::with('category')->where('status', true);

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by type (live/vod)
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $channels = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $channels->getCollection()->map(function ($channel) {
                return [
                    'id' => $channel->id,
                    'name' => $channel->name,
                    'description' => $channel->description,
                    'logo' => $channel->logo,
                    'type' => $channel->type,
                    'is_premium' => $channel->is_premium,
                    'category' => [
                        'id' => $channel->category->id,
                        'name' => $channel->category->name,
                    ],
                ];
            }),
            'pagination' => [
                'current_page' => $channels->currentPage(),
                'last_page' => $channels->lastPage(),
                'per_page' => $channels->perPage(),
                'total' => $channels->total(),
            ],
        ]);
    }

    /**
     * Show a single channel with stream URL.
     * Premium channels require active subscription.
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $channel = Channel::with('category')->find($id);

        if (!$channel || !$channel->status) {
            return response()->json([
                'success' => false,
                'message' => 'Channel not found.',
            ], 404);
        }

        $user = $request->user();
        $canStream = true;

        // Check premium access
        if ($channel->is_premium) {
            $canStream = $user && $user->hasActiveSubscription();
        }

        $data = [
            'id' => $channel->id,
            'name' => $channel->name,
            'description' => $channel->description,
            'logo' => $channel->logo,
            'type' => $channel->type,
            'is_premium' => $channel->is_premium,
            'can_stream' => $canStream,
            'category' => [
                'id' => $channel->category->id,
                'name' => $channel->category->name,
            ],
        ];

        // Only include stream URL if user can access
        if ($canStream) {
            $data['stream_url'] = $channel->stream_url;
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
