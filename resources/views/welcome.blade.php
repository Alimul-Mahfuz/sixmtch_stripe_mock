@extends('layouts._layout')
@section('title')
    Welcome
@endsection
@section('content')
    <div class="container py-5">
        <div class="row text-center mb-4">
            <div class="col">
                <h2 class="fw-bold">Choose Your Plan</h2>
            </div>
        </div>

        <div class="row justify-content-center g-4">
            @foreach ($plans as $plan)
                <div class="col-md-4 d-flex">
                    <div class="card shadow border-{{ $loop->iteration === 1 ? 'primary' : ($loop->iteration === 2 ? 'success' : 'warning') }} rounded-4 h-100 w-100">
                        <div class="card-header bg-{{ $loop->iteration === 1 ? 'primary' : ($loop->iteration === 2 ? 'success' : 'warning') }} text-white rounded-top-4">
                            <h5 class="mb-0">{{ $plan->name }}</h5>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h2 class="card-title">${{ number_format($plan->price, 2) }}
                                @if($plan->duration > 0)
                                    <span class="fs-6">/{{ $plan->duration >= 365 ? 'yr' : 'mo' }}</span>
                                @endif
                            </h2>
                            <p class="card-text">{{ $plan->description }}</p>
                            <ul class="list-unstyled text-start flex-grow-1">
                                @if($plan->duration === 0)
                                    <li>✔ Lifetime access</li>
                                    <li>✔ No recurring fees</li>
                                @else
                                    <li>✔ Duration: {{ $plan->duration }} days</li>
                                    <li>✔ Auto-Renew: {{ $plan->is_auto_renewable ? 'Yes' : 'No' }}</li>
                                    <li>✔ Grace Period: {{ $plan->grace_period }} days</li>
                                @endif
                            </ul>
                            <a href="{{route('payment.subscribe',['plan_id'=>$plan->id])}}" class="btn btn-{{ $loop->iteration === 1 ? 'outline-primary' : ($loop->iteration === 2 ? 'success' : 'warning text-white') }} mt-auto w-100">
                                {{ $plan->duration === 0 ? 'Buy Now' : 'Subscribe' }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

