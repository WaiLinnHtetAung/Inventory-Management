@extends('layouts.app')
@section('title', 'Sale Report')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-report' style="color: rgb(207, 122, 10);"></i>
        <div>Daily {{ __('messages.sale.title') }} Report</div>
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
                    <button class="btn btn-success sale_report_search">Search</button>
                </div>
            </div>
        </div>
        <div id="sale-table"></div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.sale_report_search', function() {
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
                        url: "{{ route('admin.sale.report') }}",
                        type: "POST",
                        data: {
                            start_date,
                            end_date,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            $('#sale-table').html(res);
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
