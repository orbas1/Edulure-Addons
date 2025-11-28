<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RocketAddons\Communities\Http\Requests\FeedPostRequest;
use RocketAddons\Communities\Http\Requests\StoreCommunityRequest;
use RocketAddons\Communities\Http\Resources\CentralFeedItemResource;
use RocketAddons\Communities\Http\Resources\CommunityResource;
use RocketAddons\Communities\Models\CentralFeedItem;
use RocketAddons\Communities\Models\Community;
use RocketAddons\Communities\Services\CommunityManager;
use RocketAddons\Communities\Services\MembershipService;

class CommunityController extends Controller
{
    public function __construct(
        private CommunityManager $manager,
        private MembershipService $membership
    ) {
        $this->middleware('auth');
    }

    public function index()
    {
        $communities = Community::query()->paginate();
        return CommunityResource::collection($communities);
    }

    public function store(StoreCommunityRequest $request)
    {
        $community = $this->manager->createCommunity($request->validated(), $request->user()->id);
        return new CommunityResource($community);
    }

    public function join(Request $request, Community $community)
    {
        $membership = $this->membership->joinCommunity($community, $request->user()->id);
        return response()->json(['status' => 'joined', 'membership_id' => $membership->id]);
    }

    public function leave(Request $request, Community $community)
    {
        $this->membership->leaveCommunity($community, $request->user()->id);
        return response()->json(['status' => 'left']);
    }

    public function feed(Request $request, Community $community)
    {
        $feed = CentralFeedItem::where('community_id', $community->id)->latest()->paginate();
        return CentralFeedItemResource::collection($feed);
    }

    public function postToFeed(FeedPostRequest $request, Community $community)
    {
        $item = CentralFeedItem::create(array_merge($request->validated(), [
            'community_id' => $community->id,
            'user_id' => $request->user()->id,
        ]));

        return new CentralFeedItemResource($item);
    }
}
