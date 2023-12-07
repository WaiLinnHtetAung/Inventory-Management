@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
    <style>
        .dash-info h1 {
            color: #f2f2f2;
            font-weight: bold;
            font-size: 48px;
        }

        .dash-info div {
            color: #f2f2f2;
            font-weight: bold;
            font-size: 22px;
            height: 40px;
        }

        #PurchaseDataTable_wrapper>div:nth-child(1),
        #PurchaseDataTable_wrapper>div:nth-child(3) {
            display: none;
        }

        #SaleDataTable_wrapper>div:nth-child(1),
        #SaleDataTable_wrapper>div:nth-child(3) {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-4 col-lg-3 mb-3">
                <a href="{{ route('admin.users.index') }}">
                    <div class="card cursor-pointer shadow">
                        <div class="card-body p-0 rounded" style="background: rgba(91, 182, 91, 0.863);">
                            <div class="d-flex justify-content-between align-items-center px-3 py-2">
                                <div class="dash-info">
                                    <h1>{{ $total_user }}</h1>
                                    <div>System Users</div>
                                </div>
                                <div>
                                    <img src="{{ asset('assets/img/dashboard/user.png') }}" style="opacity: .6;"
                                        width="100" alt="">
                                </div>
                            </div>
                            <div style="background: rgba(93, 179, 75, 0.863);"
                                class="mt-4 text-center p-1 text-white rounded">
                                More
                                Info<i class='bx bxs-right-arrow-circle ms-2'></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3 mb-3">
                <a href="{{ route('admin.categories.index') }}">
                    <div class="card cursor-pointer shadow">
                        <div class="card-body p-0 rounded" style="background: rgba(179, 142, 42, 0.863);">
                            <div class="d-flex justify-content-between align-items-center px-3 py-2">
                                <div class="dash-info">
                                    <h1>{{ $total_category }}</h1>
                                    <div>Category</div>
                                </div>
                                <div>
                                    <img src="{{ asset('assets/img/dashboard/category.png') }}" style="opacity: .6;"
                                        width="80" alt="">
                                </div>
                            </div>
                            <div style="background: rgba(136, 106, 25, 0.863);"
                                class="mt-4 text-center p-1 text-white rounded">
                                More
                                Info<i class='bx bxs-right-arrow-circle ms-2'></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3 mb-3">
                <a href="{{ route('admin.products.index') }}">
                    <div class="card cursor-pointer shadow">
                        <div class="card-body p-0 rounded" style="background: rgba(74, 116, 196, 0.863);">
                            <div class="d-flex justify-content-between align-items-center px-3 py-2">
                                <div class="dash-info">
                                    <h1>{{ $total_product }}</h1>
                                    <div>Products</div>
                                </div>
                                <div>
                                    <img src="{{ asset('assets/img/dashboard/product.png') }}" style="opacity: .6;"
                                        width="100" alt="">
                                </div>
                            </div>
                            <div style="background: rgba(48, 77, 129, 0.863);"
                                class="mt-4 text-center p-1 text-white rounded">
                                More
                                Info<i class='bx bxs-right-arrow-circle ms-2'></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3 mb-3">
                <a href="{{ route('admin.customers.index') }}">
                    <div class="card cursor-pointer shadow">
                        <div class="card-body p-0 rounded" style="background: rgba(214, 95, 58, 0.863);">
                            <div class="d-flex justify-content-between align-items-center px-3 py-2">
                                <div class="dash-info">
                                    <h1>{{ $total_customer }}</h1>
                                    <div>Customers</div>
                                </div>
                                <div>
                                    <img src="{{ asset('assets/img/dashboard/customer.png') }}" style="opacity: .6;"
                                        width="100" alt="">
                                </div>
                            </div>
                            <div style="background: rgba(204, 94, 66, 0.863);"
                                class="mt-4 text-center p-1 text-white rounded">
                                More
                                Info<i class='bx bxs-right-arrow-circle ms-2'></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3 mb-3">
                <a href="{{ route('admin.suppliers.index') }}">
                    <div class="card cursor-pointer shadow">
                        <div class="card-body p-0 rounded" style="background: rgba(216, 61, 208, 0.863);">
                            <div class="d-flex justify-content-between align-items-center px-3 py-2">
                                <div class="dash-info">
                                    <h1>{{ $total_supplier }}</h1>
                                    <div>Suppliers</div>
                                </div>
                                <div>
                                    <img src="{{ asset('assets/img/dashboard/supplier.png') }}" style="opacity: .6;"
                                        width="90" alt="">
                                </div>
                            </div>
                            <div style="background: rgba(148, 43, 143, 0.863);"
                                class="mt-4 text-center p-1 text-white rounded">
                                More
                                Info<i class='bx bxs-right-arrow-circle ms-2'></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3 mb-3">
                <a href="{{ route('admin.purchases.index') }}">
                    <div class="card cursor-pointer shadow">
                        <div class="card-body p-0 rounded" style="background: rgba(207, 45, 72, 0.863);">
                            <div class="d-flex justify-content-between align-items-center px-3 py-2">
                                <div class="dash-info">
                                    <h1>{{ $total_purchase }}</h1>
                                    <div>Total Purchases</div>
                                </div>
                                <div>
                                    <img src="{{ asset('assets/img/dashboard/purchase.png') }}" style="opacity: .6;"
                                        width="90" alt="">
                                </div>
                            </div>
                            <div style="background: rgba(119, 26, 41, 0.863);"
                                class="mt-4 text-center p-1 text-white rounded">
                                More
                                Info<i class='bx bxs-right-arrow-circle ms-2'></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-3 mb-3">
                <a href="{{ route('admin.sales.index') }}">
                    <div class="card cursor-pointer shadow">
                        <div class="card-body p-0 rounded" style="background: rgba(45, 161, 207, 0.863);">
                            <div class="d-flex justify-content-between align-items-center px-3 py-2">
                                <div class="dash-info">
                                    <h1>{{ $total_sale }}</h1>
                                    <div>Total Sales</div>
                                </div>
                                <div>
                                    <img src="{{ asset('assets/img/dashboard/sale.png') }}" style="opacity: .6;"
                                        width="90" alt="">
                                </div>
                            </div>
                            <div style="background: rgba(26, 96, 124, 0.863);"
                                class="mt-4 text-center p-1 text-white rounded">
                                More
                                Info<i class='bx bxs-right-arrow-circle ms-2'></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-6 mb-3">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between border-bottom mb-3">
                            <h4 class="fw-bold">Recent Purchases</h4>
                            <a href="{{ route('admin.purchases.index') }}">
                                <div class="fw-bold">
                                    See All <i class='bx bxs-right-top-arrow-circle text-success fs-4 ms-1'></i>
                                </div>
                            </a>
                        </div>

                        <table class="table table-bordered table-responsive table-striped w-100" id="PurchaseDataTable">
                            <thead>
                                <tr>
                                    <th class="no-sort"></th>
                                    <th>{{ __('messages.purchase.fields.invoice_no') }}</th>
                                    <th>{{ __('messages.purchase.fields.supplier') }}</th>
                                    <th>{{ __('messages.purchase.fields.date') }}</th>
                                    <th class="no-sort text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between border-bottom mb-3">
                            <h4 class="fw-bold">Recent Sales</h4>
                            <a href="{{ route('admin.sales.index') }}">
                                <div class="fw-bold">
                                    See All <i class='bx bxs-right-top-arrow-circle text-success fs-4 ms-1'></i>
                                </div>
                            </a>
                        </div>
                        <table class="table table-bordered table-responsive table-striped w-100" id="SaleDataTable">
                            <thead>
                                <tr>
                                    <th class="no-sort"></th>
                                    <th>{{ __('messages.sale.fields.invoice_no') }}</th>
                                    <th>{{ __('messages.sale.fields.customer') }}</th>
                                    <th>{{ __('messages.sale.fields.date') }}</th>
                                    <th class="no-sort text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            //purchase datatable
            const table = new DataTable('#PurchaseDataTable', {
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: '/admin/recent-purchase-datatable',
                columns: [{
                        data: 'plus-icon',
                        name: 'plus-icon'
                    },
                    {
                        data: 'invoice_no',
                        name: 'invoice_no'
                    },
                    {
                        data: 'supplier_id',
                        name: 'supplier_id'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'action',
                        data: 'action',
                    }
                ],
                columnDefs: [{
                    targets: 'no-sort',
                    sortable: false,
                    searchable: false
                }, {
                    targets: [0],
                    class: 'control'
                }]
            })

            //sale datatable
            const saleTable = new DataTable('#SaleDataTable', {
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: '/admin/recent-sale-datatable',
                columns: [{
                        data: 'plus-icon',
                        name: 'plus-icon'
                    },
                    {
                        data: 'invoice_no',
                        name: 'invoice_no'
                    },
                    {
                        data: 'customer_id',
                        name: 'customer_id'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'action',
                        data: 'action',
                    }
                ],
                columnDefs: [{
                    targets: 'no-sort',
                    sortable: false,
                    searchable: false
                }, {
                    targets: [0],
                    class: 'control'
                }]
            })
        })
    </script>
@endsection
