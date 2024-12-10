@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <a href="{{ route('addproduct.index') }}" class="btn btn-info">New Additional Products</a>
                        <a href="{{ route('addproduct.view') }}" class="btn btn-success">Acitve Additional Products</a>
                        <br /><br />
                        <span class="section">Edit Additional Products</span>

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
                        <form method="POST" action="{{ route('addproduct.update', $userid) }}"
                            class="form-horizontal form-label-left">
                            @csrf
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">SKU<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="name" value="{{ $product->sku }}"
                                        class="form-control col-md-7 col-xs-12" name="sku" placeholder=" "
                                        required="required" type="text">
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>




                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Stock<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="name" value="{{ $product->stock }}"
                                        class="form-control col-md-7 col-xs-12" name="stock" placeholder=" "
                                        required="required" type="text">
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Name</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <select class="select2_single form-control" tabindex="-1" name="product">

                                        @foreach ($pdtname as $item)
                                            <option {{ $product->productid == $item->id ? 'selected' : '' }}
                                                value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Name</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <select class="select2_single form-control" tabindex="-1" name="customername">

                                        @foreach ($custoname as $item)
                                            <option value="{{ $item->id }}">{{ $item->company_name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Amount <span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="amount" value="{{ $product->amount * $product->stock }}"
                                        name="amount" required="required" class="form-control col-md-7 col-xs-12 amount">
                                    @if ($errors->has('amount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                    <span class="text-danger" role="alert">
                                        <strong id="err_amount"></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_method">Payment
                                    Method<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="payment_method" name="payment_method" required="required"
                                        class="form-control col-md-7 col-xs-12 paymethod" data-validate-length-range="6"
                                        data-validate-words="2">
                                        <option value="1">Cash</option>
                                        <option
                                            value="2"{{ $product->bank_id == 0 && $product->cash == 0 && $product->due > 0 ? ' selected' : '' }}>
                                            Due</option>
                                        <option
                                            value="3"{{ $product->bank_id > 0 && $product->cash == 0 && $product->due == 0 ? ' selected' : '' }}>
                                            Cheque</option>
                                        <option
                                            value="4"{{ $product->bank_id > 0 && $product->cash > 0 ? ' selected' : '' }}>
                                            Both</option>
                                    </select>
                                    @if ($errors->has('payment_method'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('payment_method') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div id="Only_cheque_div_ID" class="Only_cheque_div" style="display:none;">
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                        for="only_cheque_bank_name">Bank Name<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
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
                            </div>

                            <div id="both_div_id" class="both_Div" style="display:none;">
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cash_amount">Cash Amount
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="cash_amount" name="cash_amount"
                                            class="form-control col-md-7 col-xs-12 both_amount"
                                            value="{{ $product->cash }}">
                                        @if ($errors->has('cash_amount'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('cash_amount') }}</strong>
                                            </span>
                                        @endif
                                        <span class="text-danger" role="alert">
                                            <strong id="err_cash_amount"></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="due_amount">Due Amount
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="due_amount" name="due_amount"
                                            class="form-control col-md-7 col-xs-12 both_amount"
                                            value="{{ $product->due }}">
                                        @if ($errors->has('due_amount'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('due_amount') }}</strong>
                                            </span>
                                        @endif
                                        <span class="text-danger" role="alert">
                                            <strong id="err_due_amount"></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                        for="both_cheque_bank_name">Bank
                                        Name<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select id="both_cheque_bank_name" name="both_cheque_bank_name"
                                            class="form-control col-md-7 col-xs-12" data-validate-length-range="6"
                                            data-validate-words="2">
                                            @foreach ($bank as $item)
                                                @if ($item->id == $product->bank_id)
                                                    <option selected value="{{ $item->id }}">{{ $item->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('both_cheque_bank_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('both_cheque_bank_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                        for="both_cheque_amount">Cheque
                                        Amount
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="both_cheque_amount" name="both_cheque_amount"
                                            class="form-control col-md-7 col-xs-12 both_amount"
                                            value="{{ $product->bank_amount }}">
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
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Created Date
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="datepicker" autocomplete="off" type="text"
                                        value="{{ $product->created_at }}" name="date"
                                        class="form-control col-md-7 col-xs-12">
                                    @if ($errors->has('date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">Frozen</option>
                                    </select>
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">

                                    <input class="btn btn-primary" type="submit" value="Update" />
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            @php
                if ($product->bank_id > 0 && $product->cash > 0 && $product->due > 0) {
                    echo "$('#both_div_id').show(300);
    $('#Only_cheque_div_ID').hide(300);
    $('#Only_cheque_div_ID').hide(300);
    $('#cash_amount').attr('required', 'required');
    $('#both_cheque_bank_name').attr('required', 'required');
    $('#both_cheque_amount').attr('required', 'required');";
                } elseif ($product->bank_id > 0) {
                    echo "$('#both_div_id').hide(300);
    $('#Only_cheque_div_ID').show(300);
    $('#only_cheque_bank_name').attr('required', 'required');";
                } else {
                    echo "$('#both_div_id').hide(300);
    $('#Only_cheque_div_ID').hide(300);
    $('#only_cheque_bank_name').removeAttr('required');
    $('#cash_amount').removeAttr('required');
    $('#both_cheque_bank_name').removeAttr('required');
    $('#both_cheque_amount').removeAttr('required');";
                }
            @endphp
            $('.both_amount,.amount').on('change', function() {
                var cashAmount = parseInt($('#cash_amount').val());
                var dueAmount = parseInt($('#due_amount').val());
                var chequeAmount = parseInt($('#both_cheque_amount').val());
                var total = cashAmount + dueAmount + chequeAmount;
                var amount = $('#amount').val();
                if (amount != total) {
                    $('.both_amount ').css({
                        "background-color": "red",
                        "color": "white",
                    });
                    return false;
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
                alert("OK");
                var paymethod_id = $('.paymethod').val();
                var err = 0;
                $("#err_amount, #err_cash_amount, #err_due_amount, #err_both_cheque_amount").text("");

                var amount = parseInt($("input[name='amount']").val());
                var cash_amount = parseInt($("input[name='cash_amount']").val());
                var due_amount = parseInt($("input[name='due_amount']").val());
                var both_cheque_amount = parseInt($("input[name='both_cheque_amount']").val());

                if (amount == "") {
                    $("#err_amount").text("Amount is Required");
                    err++;
                }
                if (cash_amount == "") {
                    $("#err_cash_amount").text("Cash Amount is Required");
                    err++;
                }
                if (due_amount == "") {
                    $("#err_due_amount").text("Due Amount is Required");
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
                        });
                        err++;
                        return false;
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
                if (paymethod_id == 3) {
                    $('#both_div_id').hide(300);
                    $('#Only_cheque_div_ID').show(300);
                    $('#only_cheque_bank_name').attr('required', 'required');
                } else if (paymethod_id == 4) {
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
