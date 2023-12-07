@extends('layouts.app')
@section('title', 'Purchases')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-report' style="color: rgb(207, 122, 10);"></i>
        <div>Daily {{ __('messages.purchase.title') }} Report</div>
    </div>

    <div class="card mt-3 p-5">
        <div class="row mb-5">
            <div class="col-2">
                <div class="form-group">
                    <label for="">Start Date</label>
                    <input type="text" class="form-control date start_date" name="start_date" placeholder="YYYY-MM-DD">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="">End Date</label>
                    <input type="text" class="form-control end_date" name="end_date" placeholder="YYYY-MM-DD"
                        style="background: transparent">
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <label for="">&nbsp;</label>
                    <button class="btn btn-success purchase_report_search">Search</button>
                </div>
            </div>
        </div>
        <div id="purchase-table"></div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.purchase_report_search', function() {
                let start_date = $('.start_date').val();
                let end_date = $('.end_date').val();

                if (!start_date || !end_date) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Please fill all date",
                    });
                } else {
                    $.ajax({
                        url: "{{ route('admin.purchase.report') }}",
                        type: "POST",
                        data: {
                            start_date,
                            end_date,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            $('#purchase-table').html(res);
                        }
                    })
                }
            })

            $(function() {
                let end_date = document.querySelector('.end_date');
                if (end_date) {
                    end_date.flatpickr({
                        dateFormat: "Y-m-d"
                    })
                }
            })
        })
    </script>
@endsection
