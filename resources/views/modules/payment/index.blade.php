@extends('layouts._layout')
@section('title')
    Payment Page
@endsection

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <h4 class="mb-0">Payment Information</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('do_subscribe') }}" method="POST">
                            @csrf
                            <input type="text" hidden name="plan_id" value="{{$plan_id}}">
                            <div class="mb-3">
                                <label for="cardName" class="form-label">Name on Card</label>
                                <input type="text" name="name_on_card"
                                       class="form-control @error('name_on_card') is-invalid @enderror" id="cardName"
                                       value="{{ old('name_on_card') }}" placeholder="John Doe">
                                @error('name_on_card')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cardNumber" class="form-label">Card Number</label>
                                <input type="text" name="card_number"
                                       class="form-control @error('card_number') is-invalid @enderror" id="cardNumber"
                                       value="{{ old('card_number') }}" placeholder="1234 5678 9012 3456">
                                @error('card_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="expiryDate" class="form-label">Expiry Date</label>
                                    <input type="text" name="expiry_date"
                                           class="form-control @error('expiry_date') is-invalid @enderror"
                                           id="expiryDate" value="{{ old('expiry_date') }}" placeholder="MM/YY">
                                    @error('expiry_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="password" name="cvv"
                                           class="form-control @error('cvv') is-invalid @enderror" id="cvv"
                                           placeholder="123">
                                    @error('cvv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="billingAddress" class="form-label">Billing Address</label>
                                <textarea name="billing_address"
                                          class="form-control @error('billing_address') is-invalid @enderror"
                                          id="billingAddress" rows="2"
                                          placeholder="123 Main St, City, Country">{{ old('billing_address') }}</textarea>
                                @error('billing_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success w-100 py-2">Pay Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
