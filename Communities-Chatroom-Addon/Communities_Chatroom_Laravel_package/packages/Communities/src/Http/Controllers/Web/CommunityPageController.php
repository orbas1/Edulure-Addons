<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Controllers\Web;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RocketAddons\Communities\Http\Controllers\Controller;
use RocketAddons\Communities\Models\CentralFeedItem;
use RocketAddons\Communities\Models\Channel;
use RocketAddons\Communities\Models\Community;
use RocketAddons\Communities\Models\CommunityMember;
use RocketAddons\Communities\Models\CommunityMemberSubscription;
use RocketAddons\Communities\Models\CommunityPricingTier;
use RocketAddons\Communities\Services\MembershipService;
use RocketAddons\Communities\Services\CommunityManager;

class CommunityPageController extends Controller
{
    public function __construct(
        private readonly MembershipService $membershipService,
        private readonly CommunityManager $communityManager
    )
    {
    }

    public function index(Request $request): View
    {
        $query = Community::query()->with(['owner', 'pricingTiers'])->withCount('members');

        if ($request->filled('visibility')) {
            $query->where('is_private', $request->get('visibility') === 'private');
        }

        if ($request->get('pricing') === 'free') {
            $query->whereDoesntHave('pricingTiers', fn($q) => $q->where('price', '>', 0));
        } elseif ($request->get('pricing') === 'paid') {
            $query->whereHas('pricingTiers', fn($q) => $q->where('price', '>', 0));
        }

        $communities = $this->applySorting($query, $request->get('sort'))->paginate(12);

        return view('addons.communities.communities.index', compact('communities'));
    }

    protected function applySorting($query, ?string $sort)
    {
        if ($sort === 'active') {
            $query->orderByDesc('updated_at');
        } else {
            $query->orderByDesc('created_at');
        }

        return $query;
    }

    public function show(Request $request, Community $community): View
    {
        $activeTab = $request->get('tab', 'feed');
        $membership = $community->members()->where('user_id', $request->user()->id)->with('role')->first();
        $subscription = CommunityMemberSubscription::where('community_id', $community->id)
            ->where('user_id', $request->user()->id)
            ->latest('expires_at')->first();
        $pricingTiers = CommunityPricingTier::where('community_id', $community->id)->get();
        $moderators = CommunityMember::with('user')->where('community_id', $community->id)
            ->whereHas('role', fn($q) => $q->where('slug', 'moderator'))
            ->get();
        $channels = Channel::where('community_id', $community->id)->orderBy('position')->get();
        $feedItems = CentralFeedItem::with(['user', 'comments.user', 'reactions'])
            ->where('community_id', $community->id)->latest()->paginate(10);
        $members = $community->members()->with(['user', 'role'])->paginate(20);
        $courses = $community->courses;
        $leaderboard = $community->leaderboardSnapshots()->latest()->limit(10)->get();

        return view('addons.communities.communities.show', compact(
            'community',
            'membership',
            'subscription',
            'pricingTiers',
            'moderators',
            'channels',
            'feedItems',
            'members',
            'courses',
            'leaderboard',
            'activeTab'
        ));
    }

    public function update(Request $request, Community $community): RedirectResponse
    {
        $this->authorize('update', $community);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_private' => ['nullable', 'boolean'],
        ]);

        $community->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'is_private' => (bool) ($data['is_private'] ?? false),
        ]);

        return back()->with('status', __('communities::communities.save'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $community = $this->communityManager->create(
            $request->user(),
            $data['name'],
            $data['description'] ?? null,
            []
        );

        return redirect()->route('communities.show', $community);
    }

    public function join(Request $request, Community $community): RedirectResponse
    {
        $this->membershipService->join($community, $request->user(), $request->get('tier'));

        return back();
    }

    public function leave(Request $request, Community $community): RedirectResponse
    {
        $this->membershipService->leave($community, $request->user());

        return back();
    }
}
