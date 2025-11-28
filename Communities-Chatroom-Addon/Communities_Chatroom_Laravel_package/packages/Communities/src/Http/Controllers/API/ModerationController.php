<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Controllers\API;

use Illuminate\Routing\Controller;
use RocketAddons\Communities\Http\Requests\ModerationReportRequest;
use RocketAddons\Communities\Services\ModerationService;

class ModerationController extends Controller
{
    public function __construct(private ModerationService $moderationService)
    {
        $this->middleware('auth');
    }

    public function store(ModerationReportRequest $request)
    {
        $report = $this->moderationService->createReport(
            $request->user()->id,
            $request->input('target_type'),
            (int) $request->input('target_id'),
            $request->input('reason')
        );

        return response()->json(['report_id' => $report->id]);
    }
}
