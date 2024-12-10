@extends('layouts.app')

@section('content')
    <!--------------------------------------------->
    <div class="container">
        <div class="row">
            <form action="{{ route('invoice.top_sheet_save') }}" method="post">
                @csrf
                <div>
                    <div id="car_parent">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Choose Customer: </label>
                                        <select class="form-control" name="customerid">
                                            @foreach ($customers as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->contact_person }} -
                                                    {{ $value->company_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <br />
                                        <label>Invoice Number Start: </label>
                                        <input type="number" name="start" value="" class="form-control">
                                    </div>
                                    <div class="col-sm-12">
                                        <br />
                                        <label>Invoice Number End: </label>
                                        <input type="number" name="end" value="" class="form-control">
                                    </div>
                                    <div class="top-sheet-amount" style="display: none">
                                        <div class="col-sm-12">
                                            <br />
                                            <hr />
                                            <hr />
                                            <h4 id="payable-amount"></h4>
                                            <label for="">Paid Amount</label>
                                            <input type="text" name="amount" required class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <br />
                                            <label for="">Vat</label>
                                            <input type="text" name="vat" value="0" required
                                                class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <br />
                                            <label for="">Tax</label>
                                            <input type="text" name="tax" value="0" required
                                                class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <br />
                                            <label for="">Date</label>
                                            <input type="text" name="date" value="" id="datepicker"
                                                value="{{ date('Y-m-d') }}" required class="form-control"
                                                autocomplete="off">
                                        </div>
                                        <div class="col-sm-12">
                                            <br />
                                            <label for="">Description</label>
                                            <input type="text" name="description" value="" required
                                                class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <br />
                                            <label>Account: </label>
                                            <select class="form-control" name="bankid">
                                                @foreach ($banks as $key => $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <br />
                                            <label>Payment Method: </label>
                                            <select class="form-control" name="method">
                                                @foreach ($method as $key => $value)
                                                    @if (isset($transaction) && $transaction->method == $key)
                                                        <option selected value="{{ $key }}">{{ $value }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-sm-12">
                                        <br />
                                        <span class="btn btn-success">Search</span>
                                        <input type="submit" name="" value="Save" class="btn btn-info"
                                            style="display: none">
                                    </div>
                                </div>

                            </div>
                        </div>


                        <br /><br /><br />
                    </div>
                </div>
            </form>

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
                    $.ajax({
                        type: 'POST',
                        data: {
                            "_token": $("meta[name='csrf-token']").attr("content"),
                            "start": start,
                            "end": end,
                            "customerid": customerid
                        },
                        url: "{{ route('invoice.top_sheet_search') }}",
                        async: false,
                        success: function(data) {
                            data = Number(data);
                            if (data > 0) {
                                $("#payable-amount").text("Total Amount: " + data);
                                $(".top-sheet-amount").show();
                                $(".btn-info").show();
                            } else if (data < 0) {
                                alert("No invoice found");
                            } else {
                                alert("Some invoice already paid");
                            }
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
