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
                    <form method="POST" action="{{ route('admin2') }}" class="form-horizontal form-label-left">
                        @csrf
                        <span class="section">Create Employee</span>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">User Name<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6"
                                    data-validate-words="2" name="name" placeholder=" " required="required" type="text">
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif  
                            </div>
                        </div>

                        <div class="item form-group">
                            <label for="password" class="control-label col-md-3">Password</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="password" type="password" name="password" data-validate-length="6,8" class="form-control col-md-7 col-xs-12"
                                    required="required">
                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="password2" type="password" name="password_confirmation" data-validate-linked="password"
                                    class="form-control col-md-7 col-xs-12" required="required">
                            </div>
                        </div>
                        <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="contract">Contract Number <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" value="{{ old('contract') }}" id="contract" name="contract" required="required" class="form-control col-md-7 col-xs-12">
                                    @if ($errors->has('contract'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('contract') }}</strong>
                                    </span>
                                    @endif  
                                </div>
                            </div>
                        <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="creBy">Created By <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12"> 
                                    <select name="creBy" id="creBy"  required="required" class="form-control col-md-7 col-xs-12">
                                        <option value="0">Select One</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Operator</option>
                                    </select>
                                    @if ($errors->has('creBy'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('creBy') }}</strong>
                                    </span>
                                    @endif  
                                </div>
                            </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">

                                <input class="btn btn-primary" type="submit" value="Save" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
