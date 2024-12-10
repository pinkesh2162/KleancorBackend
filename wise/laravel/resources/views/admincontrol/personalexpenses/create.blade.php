@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
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
                        <form method="POST" novalidate action="{{ route('createexpenses') }}"
                            class="form-horizontal form-label-left">
                            @csrf
                            <span class="section">Create Personal Expense</span>
                            <!--
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="project_name">Project Name<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   
                                    @if ($errors->has('project_name'))
    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('project_name') }}</strong>
                                    </span>
    @endif
                                </div>
                            </div>-->
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Title <span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{ old('title') }}" type="text" id="title" name="title"
                                        required="required" class="form-control col-md-7 col-xs-12">
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!--
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bonus">Description <span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea required="required" name="description" id="description" cols="10" rows="5"
                                        class="form-control col-md-7 col-xs-12">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
    @endif
                                </div>
                            </div>-->
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Amount <span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{ old('amount') }}" type="text" id="amount" name="amount"
                                        required="required" class="form-control col-md-7 col-xs-12 amount">
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Date

                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="datepicker" autocomplete="off" type="text" value="{{ old('date') }}"
                                        name="date" class="form-control col-md-7 col-xs-12">
                                    @if ($errors->has('date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!--
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_method">Payment
                                    Method<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="payment_method" name="payment_method" required="required" class="form-control col-md-7 col-xs-12 paymethod"
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
                            </div>
                           
                            <div id="both_div_id" class="both_Div" style="display:none;">
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cash_amount">Cash Amount
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input {{ old('cash_amount') }} type="text" id="cash_amount" name="cash_amount" class="form-control col-md-7 col-xs-12 both_amount">
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="both_cheque_amount">Cheque
                                        Amount
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="both_cheque_amount" name="both_cheque_amount" class="form-control col-md-7 col-xs-12 both_amount">
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
                            </div>-->
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">

                                    <input id="submit" class="btn btn-primary" type="submit" value="Save" />
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

            $('.both_amount,.amount').on('change', function() {
                var cashAmount = parseInt($('#cash_amount').val());
                var chequeAmount = parseInt($('#both_cheque_amount').val());
                var total = cashAmount + chequeAmount;
                var amount = $('#amount').val();

                if (amount == "") {
                    $('.amount').css({
                        "background-color": "white",
                        "color": "black",
                    });
                    $("#err_amount").text("");
                    $("#err_cash_amount").text("Remove this Amount");
                    $("#err_both_cheque_amount").text("Remove this Amount");
                } else if (amount != total) {
                    $('.both_amount ').css({
                        "background-color": "red",
                        "color": "white",
                    });
                } else {
                    $('.both_amount, .amount').css({
                        "background-color": "white",
                        "color": "black",
                    });
                    $("#err_amount").text("");
                    $("#err_cash_amount").text("");
                    $("#err_both_cheque_amount").text("");
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
                if (paymethod_id == 3) {
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
