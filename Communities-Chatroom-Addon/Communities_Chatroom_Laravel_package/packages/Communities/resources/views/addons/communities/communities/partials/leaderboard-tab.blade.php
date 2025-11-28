<div class="leaderboard-filters d-flex gap-2 mb-2">
    <form method="get" class="d-flex gap-2">
        <input type="hidden" name="tab" value="leaderboard">
        <select name="period" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="week" @selected(request('period')==='week')>{{ __('communities::communities.period_week') }}</option>
            <option value="month" @selected(request('period')==='month')>{{ __('communities::communities.period_month') }}</option>
            <option value="all" @selected(request('period')==='all')>{{ __('communities::communities.period_all') }}</option>
        </select>
    </form>
</div>
@include('addons.communities.leaderboard.partials.leaderboard-table', ['entries' => $leaderboard])
