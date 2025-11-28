<div class="pricing-tier-card card h-100">
    <div class="card-body d-flex flex-column">
        <h5 class="card-title">{{ $tier->name }}</h5>
        <p class="card-text text-muted">{{ $tier->description }}</p>
        <div class="display-6">{{ $tier->price > 0 ? currency_format($tier->price, $tier->currency ?? 'USD') : __('communities::communities.free') }}</div>
        <div class="text-muted small mb-3">{{ __('communities::communities.billing_' . $tier->billing_interval) }}</div>
        <ul class="list-unstyled flex-grow-1">
            @foreach(($tier->features ?? []) as $feature)
                <li class="d-flex align-items-center gap-2"><span class="text-success">✓</span> <span>{{ $feature }}</span></li>
            @endforeach
        </ul>
        <form method="post" action="{{ route('communities.join', $community) }}" class="mt-auto">
            @csrf
            <input type="hidden" name="tier" value="{{ $tier->id }}">
            <button class="btn btn-primary w-100" @if(!$tier->is_active) disabled @endif>{{ __('communities::communities.choose_tier') }}</button>
        </form>
    </div>
</div>
