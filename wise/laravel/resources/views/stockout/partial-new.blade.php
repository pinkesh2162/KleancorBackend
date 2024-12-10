@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <br /><br />
                        <span class="section">{{ $product->title }}</span>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-success" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-3">
                                @if ($product->due > 0)
                                    <form method="POST" action="{{ route('addproduct.status_store', $product->id) }}"
                                        class="form-horizontal form-label-left">
                                        @csrf
                                        <div class="item form-group">
                                            <label for="amount">Total Amount <span class="required">*</span>
                                            </label>
                                            <input type="text" id="amount" name="amount" required="required"
                                                class="form-control col-md-7 col-xs-12 amount">
                                            @if ($errors->has('amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('amount') }}</strong>
                                                </span>
                                            @endif
                                            <span class="text-danger" role="alert">
                                                <strong id="err_amount"></strong>
                                            </span>
                                        </div>
                                        <div class="item form-group">
                                            <label for="payment_method">Payment
                                                Method<span class="required">*</span>
                                            </label>
                                            <select id="payment_method" name="payment_method" required="required"
                                                class="form-control col-md-7 col-xs-12 paymethod"
                                                data-validate-length-range="6" data-validate-words="2">
                                                <option value="1">Cash</option>
                                                <option value="2">Cheque</option>
                                                <option value="3">Both</option>
                                            </select>
                                            @if ($errors->has('payment_method'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('payment_method') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div id="Only_cheque_div_ID" class="Only_cheque_div" style="display:none;">
                                            <div class="item form-group">
                                                <label for="only_cheque_bank_name">Bank
                                                    Name<span class="required">*</span>
                                                </label>
                                                <select id="only_cheque_bank_name" name="only_cheque_bank_name"
                                                    class="form-control col-md-7 col-xs-12" data-validate-length-range="6"
                                                    data-validate-words="2">
                                                    @foreach ($bank as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('only_cheque_bank_name'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('only_cheque_bank_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div id="both_div_id" class="both_Div" style="display:none;">
                                            <div class="item form-group">
                                                <label for="cash_amount">Cash Amount
                                                    <span class="required">*</span>
                                                </label>
                                                <input type="text" id="cash_amount" value="0" name="cash_amount"
                                                    class="form-control col-md-7 col-xs-12 both_amount">
                                                @if ($errors->has('cash_amount'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('cash_amount') }}</strong>
                                                    </span>
                                                @endif
                                                <span class="text-danger" role="alert">
                                                    <strong id="err_cash_amount"></strong>
                                                </span>
                                            </div>

                                            <div class="item form-group">
                                                <label for="both_cheque_bank_name">Bank
                                                    Name<span class="required">*</span>
                                                </label>
                                                <select id="both_cheque_bank_name" name="both_cheque_bank_name"
                                                    class="form-control col-md-7 col-xs-12" data-validate-length-range="6"
                                                    data-validate-words="2">
                                                    @foreach ($bank as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('both_cheque_bank_name'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('both_cheque_bank_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="item form-group">
                                                <label for="both_cheque_amount">Cheque
                                                    Amount
                                                    <span class="required">*</span>
                                                </label>
                                                <input type="text" value="0" id="both_cheque_amount"
                                                    name="both_cheque_amount"
                                                    class="form-control col-md-7 col-xs-12 both_amount">
                                                @if ($errors->has('both_cheque_amount'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('both_cheque_amount') }}</strong>
                                                    </span>
                                                @endif
                                                <span class="text-danger" role="alert">
                                                    <strong id="err_both_cheque_amount"></strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label for="date">Created Date<span class="required">*</span></label>
                                            <input id="datepicker" autocomplete="off" type="text"
                                                value="{{ old('date') }}" name="date"
                                                class="form-control col-md-7 col-xs-12" required>
                                            @if ($errors->has('date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="ln_solid"></div>
                                        <input id="submit" class="btn btn-primary" type="submit" value="Save" />
                                    </form>
                                @endif
                                <br />
                                <br />
                            </div>
                            <div class="col-sm-9">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Date</td>
                                        <td>Bank Name</td>
                                        <td>Cheque Payment</td>
                                        <td>Cash</td>
                                        <td>Total</td>
                                        <td width="20">Action</td>
                                    </tr>
                                    @php
                                        $paid = 0;
                                    @endphp
                                    @foreach ($partial as $key => $value)
                                        <tr>
                                            <td>{{ $value->date }}</td>
                                            <td>{{ $value->name == 'Cash' ? '---' : $value->name }}</td>
                                            <td>{{ number_format($value->cheque, 2) }}</td>
                                            <td>{{ number_format($value->cash, 2) }}</td>
                                            <td>{{ number_format($value->cheque + $value->cash, 2) }}</td>
                                            <td>
                                                <a href="{{ route('addproduct.status_delete', $value->id) }}"
                                                    class="btn btn-danger btn-xs"
                                                    onclick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-pencil"></i>
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                        @php
                                            $paid += $value->cheque + $value->cash;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="6">
                                            <h4 class="pull-right"
                                                style="line-height: 26px; font-size: 16px; color: #000">
                                                Total Amount: Taka
                                                {{ number_format($product->bank_amount + $product->due + $product->cash + $paid, 2) }}
                                                <br />
                                                Down Payment: Taka
                                                {{ number_format($product->cash + $product->bank_amount, 2) }} <br />
                                                Total Paid: Taka {{ number_format($paid, 2) }} <br />
                                                Total Due: Taka {{ number_format($product->due, 2) }} <br />
                                            </h4>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('.both_amount, .amount').on('change', function() {
                var cashAmount = parseInt($('#cash_amount').val());
                var chequeAmount = parseInt($('#both_cheque_amount').val());
                var total = cashAmount + chequeAmount;

                var amount = $('#amount').val();
                if (amount != total) {
                    $('.both_amount ').css({
                        "background-color": "red",
                        "color": "white",
                    });
                } else {
                    $('.both_amount, .amount').css({
                        "background-color": "white",
                        "color": "black",
                    })
                }
            });
            // jquery validation
            //================================================================

            $("body").on("click", "#submit", function() {
                var paymethod_id = $('.paymethod').val();
                var err = 0;
                $("#err_amount, #err_cash_amount , #err_both_cheque_amount").text("");

                var amount = parseInt($("input[name='amount']").val());
                var cash_amount = parseInt($("input[name='cash_amount']").val());
                var both_cheque_amount = parseInt($("input[name='both_cheque_amount']").val());

                if (amount == "") {
                    $("#err_amount").text("Amount is Required");
                    err++;
                }
                if (cash_amount == "") {
                    $("#err_cash_amount").text("Cash Amount is Required");
                    err++;
                }
                if (both_cheque_amount == "") {
                    $("#err_both_cheque_amount").text("Check Amount is Required");
                    err++;
                }
                if (paymethod_id == 4) {
                    var total_amount = cash_amount + both_cheque_amount;

                    if (amount != total_amount) {
                        $('.both_amount, .amount').css({
                            "background-color": "red",
                            "color": "white",
                        })
                        $("#err_amount").text("Amount not match");
                        $("#err_cash_amount").text("Cash Amount not match");
                        $("#err_both_cheque_amount").text("Check Amount not match");
                        err++;
                    }
                    /*
          else {
          $('.both_amount').css({
          "background-color": "white",
          "color": "black",
        })
      }*/

                    if (err > 0) {
                        return false;
                    }
                    return true;
                }
            });

            //===============================================================

            $('.paymethod').change(function() {
                var paymethod_id = $(this).val();
                if (paymethod_id == 2) {
                    $('#both_div_id').hide(300);
                    $('#Only_cheque_div_ID').show(300);
                    $('#only_cheque_bank_name').attr('required', 'required');
                } else if (paymethod_id == 3) {
                    $('#both_div_id').show(300);
                    $('#Only_cheque_div_ID').hide(300);
                    $('#Only_cheque_div_ID').hide(300);
                    $('#cash_amount').attr('required', 'required');
                    $('#both_cheque_bank_name').attr('required', 'required');
                    $('#both_cheque_amount').attr('required', 'required');
                } else {
                    $('#both_div_id').hide(300);
                    $('#Only_cheque_div_ID').hide(300);
                    $('#only_cheque_bank_name').removeAttr('required');
                    $('#cash_amount').removeAttr('required');
                    $('#both_cheque_bank_name').removeAttr('required');
                    $('#both_cheque_amount').removeAttr('required');
                }
            }); // show hide end
            //--------------------------------css

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
