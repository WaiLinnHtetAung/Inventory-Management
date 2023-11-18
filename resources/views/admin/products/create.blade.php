@extends('layouts.app')
@section('title', 'Create Product')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-server' style="color: rgb(130, 4, 189);"></i>
        <div>{{ __('messages.product.title') }} Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">{{ __('messages.product.title') }} Creation</span>

        <form action="{{ route('admin.products.store') }}" method="post" id="product_create" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.product.fields.name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.product.fields.category') }}</label>
                        <select name="category_id" id="" class="form-control select2"
                            data-placeholder="--- Please Select ---">
                            <option value=""></option>
                            @foreach ($categories as $key => $value)
                                <option value="{{ $key }}" {{ old('category_id') == $key ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="row">
                        <div class="col-4 me-0 pe-0">
                            <div class="form-group mb-4">
                                <label for="">{{ __('messages.product.fields.price') }}</label>
                                <select name="currency" id="" class="form-select text-white bg-info">
                                    <option value="MMK">MMK</option>
                                    <option value="USD">USD</option>
                                    <option value="THB">THB</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-7 ms-0 ps-0">
                            <div class="form-group mb-4">
                                <label for="">&nbsp;</label>
                                <input type="number" name="price" class="form-control" value="{{ old('price', '0') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.product.fields.qty') }}</label>
                        <input type="number" name="qty" class="form-control" value="{{ old('qty', 0) }}">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group mb-4">
                        <label for="">{{ __('messages.product.fields.photo') }}</label>
                        <input type="file" name="photo" class="form-control" onchange="showPreview(this);">
                        <img src="" class="mt-3" alt="" id="preview_img">
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreProductRequest', '#product_create') !!}

    <script>
        let showPreview = (input) => {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview_img').attr('src', e.target.result).width(150).height(150);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
