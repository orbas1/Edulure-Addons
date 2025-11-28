<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Controllers\API;

use Illuminate\Routing\Controller;
use RocketAddons\Communities\Http\Resources\HeatmapResource;
use RocketAddons\Communities\Models\ActivityHeatmap;
use App\Models\User;

class HeatmapController extends Controller
{
    public function show(User $user)
    {
        $heatmaps = ActivityHeatmap::where('user_id', $user->id)->get();
        return HeatmapResource::collection($heatmaps);
    }
}
