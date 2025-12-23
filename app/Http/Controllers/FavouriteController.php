<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Favourite;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function toggleFavorite(Request $request)
    {
        $request->validate([
            'type' => 'required|in:user,service',
            'id' => 'required|integer',
        ]);

        $user = auth()->user();

        $map = [
            'user' => \App\Models\User::class,
            'service' => \App\Models\Service::class,
        ];

        $modelClass = $map[$request->type];

        $exists = Favourite::where([
            'user_id' => $user->id,
            'favouritable_id' => $request->id,
            'favouritable_type' => $modelClass,
        ])->first();

        if ($exists) {
            $exists->delete();

            return ApiResponse::success(
                ['favourited' => false],
                'Removed from favourites'
            );
        }

        Favourite::create([
            'user_id' => $user->id,
            'favouritable_id' => $request->id,
            'favouritable_type' => $modelClass,
        ]);

        return ApiResponse::success(
            ['favourited' => true],
            'Added to favourites'
        );
    }

    public function listFavorites()
    {
        $user = auth()->user();

        $favorites = Favourite::with('favouritable')
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($favourite) {

                $model = $favourite->favouritable;

                if (! $model) {
                    return null;
                }

                // USER favourite
                if ($favourite->favouritable_type === \App\Models\User::class) {
                    return [
                        'type' => 'user',
                        'id' => $model->id,
                        'name' => $model->name,
                    ];
                }

                // SERVICE favourite
                if ($favourite->favouritable_type === \App\Models\Service::class) {
                    return [
                        'type' => 'service',
                        'id' => $model->id,
                        'name' => $model->name,
                        'price_per_hour' => $model->price_per_hour,
                        'category_id' => $model->category_id,
                    ];
                }

                return null;
            })
            ->filter()
            ->values();

        return ApiResponse::success(
            $favorites,
            'Favourite list fetched successfully'
        );
    }
}
