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
                        <form method="POST" action="{{ route('updatebank', $bank->id) }}"
                            class="form-horizontal form-label-left">
                            @csrf
                            <span class="section">Create Bank Information</span>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Bank Name<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{ $bank->name }}" id="name"
                                        class="form-control col-md-7 col-xs-12" data-validate-length-range="6"
                                        data-validate-words="2" name="name" required="required" type="text">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="accountno">Account No <span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{ $bank->account_no }}" type="text" id="accountno" name="accountno"
                                        required="required" class="form-control col-md-7 col-xs-12">
                                    @if ($errors->has('accountno'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('accountno') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="branch">Branch <span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{ $bank->branch }}" type="text" id="branch" name="branch"
                                        required="required" class="form-control col-md-7 col-xs-12">
                                    @if ($errors->has('branch'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('branch') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="balanch">Balanch <span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{ $bank->balanch }}" type="text" id="balanch" name="balanch"
                                        required="required" class="form-control col-md-7 col-xs-12">
                                    @if ($errors->has('balanch'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('balanch') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Created Date

                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="datepicker" autocomplete="off" type="text"
                                        value="{{ $bank->created_at }}" name="date"
                                        class="form-control col-md-7 col-xs-12">
                                    @if ($errors->has('date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <a href="{{ route('allviewbank') }}" class="btn btn-primary">Back</a>
                                    <input class="btn btn-info" type="submit" value="Update" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
