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
                    <form method="POST" novalidate action="{{ route('createexpenses') }}" class="form-horizontal form-label-left" >
                        @csrf
                        <span class="section">Create  Sells</span>
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
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Title <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input value="{{ old('title') }}" type="text" id="title" name="title" required="required" class="form-control col-md-7 col-xs-12">
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
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Amount <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input value="{{ old('amount') }}" type="text" id="amount" name="amount" required="required" class="form-control col-md-7 col-xs-12 amount">
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


@endsection
