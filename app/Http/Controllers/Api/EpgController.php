<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\EpgProgram;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EpgController extends Controller
{
    /**
     * Get EPG programs for a channel.
     * Optionally filter by date.
     */
    public function channelPrograms(Request $request, int $id): JsonResponse
    {
        $channel = Channel::find($id);

        if (!$channel) {
            return response()->json([
                'success' => false,
                'message' => 'Channel not found.',
            ], 404);
        }

        $query = EpgProgram::where('channel_id', $id);

        // Filter by date
        if ($request->has('date')) {
            $date = $request->date;
            $query->whereDate('start_time', $date);
        } else {
            // Default: show today's programs
            $query->whereDate('start_time', today());
        }

        $programs = $query->orderBy('start_time', 'asc')->get();

        // Find current program
        $now = now();
        $currentProgram = null;

        return response()->json([
            'success' => true,
            'data' => [
                'channel' => [
                    'id' => $channel->id,
                    'name' => $channel->name,
                ],
                'programs' => $programs->map(function ($program) use ($now) {
                    $isLive = $now->between($program->start_time, $program->end_time);

                    return [
                        'id' => $program->id,
                        'title' => $program->title,
                        'description' => $program->description,
                        'start_time' => $program->start_time->toIso8601String(),
                        'end_time' => $program->end_time->toIso8601String(),
                        'is_live' => $isLive,
                    ];
                }),
            ],
        ]);
    }
}
