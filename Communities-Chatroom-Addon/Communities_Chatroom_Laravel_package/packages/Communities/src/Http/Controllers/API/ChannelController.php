<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Controllers\API;

use Illuminate\Routing\Controller;
use RocketAddons\Communities\Http\Resources\ChannelResource;
use RocketAddons\Communities\Models\Channel;
use RocketAddons\Communities\Models\Community;

class ChannelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Community $community)
    {
        $channels = $community->channels()->orderBy('position')->get();
        return ChannelResource::collection($channels);
    }
}
