@extends('layouts._layout')

@section('title')
    My Subscriptions
@endsection

@section('content')
    <div class="container py-5">
        <div class="row">
            @forelse ($subscriptions as $subscription)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                {{ $subscription->subscription_plans->name ?? 'Unknown Plan' }}
                            </h5>
                            <p class="card-text">
                                <strong>Price:</strong>
                                ${{ number_format($subscription->subscription_plans->price ?? 0, 2) }}<br>

                                <strong>Status:</strong>
                                {!! $subscription->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}<br>

                                <strong>Auto-renew:</strong>
                                {{ $subscription->is_autorenew ? 'Yes' : 'No' }}<br>

                                <strong>Expires At:</strong>
                                {{ \Carbon\Carbon::parse($subscription->expires_at)->format('M d, Y') }}
                            </p>

                            @if($subscription->is_active)
                                <form action="{{ route('subscriptions.cancel') }}" method="POST" class="mt-auto">
                                    @csrf
                                    <input type="hidden" name="user_subscription_id" value="{{ $subscription->id }}">
                                    <button type="submit" class="btn btn-danger w-100">
                                        Cancel Subscription
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        You have no subscriptions yet.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
