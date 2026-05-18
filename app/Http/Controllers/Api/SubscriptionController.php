<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscribeRequest;
use App\Models\Payment;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * List all available subscription plans.
     */
    public function plans(): JsonResponse
    {
        $plans = SubscriptionPlan::where('status', true)->get();

        return response()->json([
            'success' => true,
            'data' => $plans->map(function ($plan) {
                return [
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'price' => $plan->price,
                    'duration_days' => $plan->duration_days,
                    'description' => $plan->description,
                ];
            }),
        ]);
    }

    /**
     * Subscribe to a plan.
     */
    public function subscribe(SubscribeRequest $request): JsonResponse
    {
        $user = $request->user();
        $plan = SubscriptionPlan::findOrFail($request->subscription_plan_id);

        // Check if user already has an active subscription
        if ($user->hasActiveSubscription()) {
            return response()->json([
                'success' => false,
                'message' => 'You already have an active subscription.',
            ], 409);
        }

        $startDate = now();
        $endDate = now()->addDays($plan->duration_days);

        // Create user subscription
        $subscription = UserSubscription::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
        ]);

        // Create payment record
        $payment = Payment::create([
            'user_id' => $user->id,
            'amount' => $plan->price,
            'payment_id' => $request->payment_id ?? 'PAY-' . strtoupper(uniqid()),
            'method' => $request->method ?? 'unknown',
            'status' => 'completed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription activated successfully.',
            'data' => [
                'subscription' => [
                    'id' => $subscription->id,
                    'plan' => $plan->name,
                    'start_date' => $subscription->start_date->toDateString(),
                    'end_date' => $subscription->end_date->toDateString(),
                    'status' => $subscription->status,
                ],
                'payment' => [
                    'id' => $payment->id,
                    'amount' => $payment->amount,
                    'payment_id' => $payment->payment_id,
                    'status' => $payment->status,
                ],
            ],
        ], 201);
    }

    /**
     * Get user's subscription status.
     */
    public function status(Request $request): JsonResponse
    {
        $user = $request->user();
        $activeSubscription = $user->activeSubscription();

        if (!$activeSubscription) {
            return response()->json([
                'success' => true,
                'data' => [
                    'has_subscription' => false,
                    'subscription' => null,
                ],
            ]);
        }

        $activeSubscription->load('subscriptionPlan');

        return response()->json([
            'success' => true,
            'data' => [
                'has_subscription' => true,
                'subscription' => [
                    'id' => $activeSubscription->id,
                    'plan' => [
                        'id' => $activeSubscription->subscriptionPlan->id,
                        'name' => $activeSubscription->subscriptionPlan->name,
                    ],
                    'start_date' => $activeSubscription->start_date->toDateString(),
                    'end_date' => $activeSubscription->end_date->toDateString(),
                    'status' => $activeSubscription->status,
                    'days_remaining' => now()->diffInDays($activeSubscription->end_date, false),
                ],
            ],
        ]);
    }
}
