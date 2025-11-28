<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Controllers\Web;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;
use RocketAddons\Communities\Http\Controllers\Controller;
use RocketAddons\Communities\Models\Community;
use RocketAddons\Communities\Models\GamificationProfile;
use RocketAddons\Communities\Models\ModerationReport;

class AdminPageController extends Controller
{
    public function index(): View
    {
        return view('addons.communities.admin.index');
    }

    public function settings(): View
    {
        $config = config('communities');

        return view('addons.communities.admin.settings', compact('config'));
    }

    public function saveSettings(Request $request): RedirectResponse
    {
        // In production we would persist to database or config store; here we simply acknowledge.
        return back()->with('status', __('communities::communities.save'));
    }

    public function communities(): View
    {
        $communities = Community::with('owner')->withCount('members')->paginate(20);

        return view('addons.communities.admin.communities', compact('communities'));
    }

    public function deactivate(Community $community): RedirectResponse
    {
        $community->update(['is_active' => false]);

        return back();
    }

    public function moderation(): View
    {
        $reports = ModerationReport::with('reporter')->latest()->paginate(30);

        return view('addons.communities.admin.moderation', compact('reports'));
    }

    public function resolveReport(ModerationReport $report): RedirectResponse
    {
        $report->update(['status' => 'resolved']);

        return back();
    }

    public function banFromReport(ModerationReport $report): RedirectResponse
    {
        // Hook into moderation service in full implementation
        return back();
    }

    public function gamification(): View
    {
        $topUsers = GamificationProfile::with('user')->orderByDesc('points')->limit(10)->get();
        $levels = config('communities.gamification.levels');

        return view('addons.communities.admin.gamification', compact('topUsers', 'levels'));
    }

    public function saveGamification(Request $request): RedirectResponse
    {
        return back()->with('status', __('communities::communities.save'));
    }
}
