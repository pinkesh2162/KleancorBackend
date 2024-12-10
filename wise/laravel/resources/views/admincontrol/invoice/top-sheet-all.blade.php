@extends('layouts.app')

@section('content')
    <!--------------------------------------------->
    <div class="container">
        <div class="row">
            <div>
                <div id="car_parent">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped">
                                <tr>
                                    <th>Date</th>
                                    <th>Invoice Number</th>
                                    <th>Customer</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Tax</th>
                                    <th>Vat</th>
                                    <th>Discount</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($transaction as $key => $value)
                                    <tr>
                                        <td>{{ $value->date }}</td>
                                        <td>{{ $value->invoice_start }}-{{ $value->invoice_end }}</td>
                                        <td>{{ $value->company_name }}</td>
                                        <td>{{ $value->description }}</td>
                                        <td>{{ $value->amount }}</td>
                                        <td>{{ $value->tax }}</td>
                                        <td>{{ $value->vat }}</td>
                                        <td>{{ $value->discount }}</td>
                                        <td>
                                            <a href="{{ route('invoice.top_sheet_print', $value->id) }}"
                                                class="btn btn-info btn-xs">Print</a>
                                            <a href="{{ route('invoice.top_sheet_delete', $value->id) }}"
                                                class="btn btn-danger btn-xs"
                                                onclick="return confirm('Are you want to delete this?');">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {{ $transaction->links() }}
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    </div>





    <script>
        $(document).ready(function() {


            $(".btn-success").click(function(event) {
                var start = parseInt($("input[name='start']").val());
                var end = parseInt($("input[name='end']").val());
                var customerid = parseInt($("select[name='customerid']").val());

                if (start > 0 && end > 0) {
                    $(".top-sheet-amount").show();
                    $(".btn-info").show();

                    $.ajax({
                        type: 'POST',
                        data: {
                            "_token": $("meta[name='csrf-token']").attr("content"),
                            "start": start,
                            "end": end,
                            "customerid": customerid
                        },
                        url: "{{ route('invoice.top_sheet_search') }}",
                        success: function(data) {
                            $("#payable-amount").text("Total Amount: " + data);
                        }
                    });
                } else {
                    alert("Invalid invoice number");
                }
            });
        });
    </script>


    <!-- Date Picker Script Start -->
    <script>
        $(function() {
            $("#datepicker").datepicker({
                minDate: new Date(2024, 6, 5),
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
            });
        });
    </script>
    <!-- Date Picker Script End -->
@endsection
