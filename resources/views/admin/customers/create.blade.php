@extends('layouts.app')
@section('title', 'Create Customer')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-group' style="color: rgb(13, 141, 9);"></i>
        <div>{{ __('messages.customer.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.customer.title') }} Creation</span>

        <form action="{{ route('admin.customers.store') }}" method="post" id="customer_create">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.customer.fields.name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.customer.fields.email') }}</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.customer.fields.phone') }}</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.customer.fields.address') }}</label>
                        <textarea name="address" id="" cols="30" rows="5" class="form-control"
                            placeholder="Enter your address ...">{{ old('address') }}</textarea>
                    </div>
                </div>

            </div>
            <div class="mt-3">
                <button class="btn btn-secondary back-btn">Cancel</button>
                <button class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreCustomerRequest', '#customer_create') !!}

@endsection
