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
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif
                    @if (session('msg'))
                    <div class="alert alert-success" role="alert">
                        {{ session('msg') }}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('updatepassword') }}" class="form-horizontal form-label-left">
                        @csrf
                        <span class="section">Change Password</span>

                        <div class="item form-group">
                          <label for="oldpassword" class="control-label col-md-3"> Old Password</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="oldpassword" type="password" name="oldpassword" data-validate-length="6,8" class="form-control col-md-7 col-xs-12"
                                  required="required">
                              @if ($errors->has('oldpassword'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('oldpassword') }}</strong>
                              </span>
                              @endif
                          </div>
                      </div>
                        <div class="item form-group">
                            <label for="password" class="control-label col-md-3"> New Password</label>
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
                        <!--
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
                            </div>-->
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">

                                <input class="btn btn-primary" type="submit" value="Change Password" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection












<!--
<form method="POST" action="{{ route('register') }}">
  @csrf
        <h1>Create Account</h1>
        <div>
          <input type="text" class="form-control" placeholder="Username" name="name" required autofocus />
        </div>
        <div>
          <input type="email" class="form-control" placeholder="Email" name="email" required />
        </div>
        <div>
          <input type="password" class="form-control" placeholder="Password" name="password" required />
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
       
        <div>
          <input type="password" class="form-control" placeholder="Cofirm Password" name="password_confirmation" required />
           
        </div>

        <div>
          <input type="submit" value="Register now" />
        </div>

        <div class="clearfix"></div>

        <div class="separator">
          <p class="change_link">Already a member?
            <a href="#signin" class="to_register"> Log in </a>
          </p>

          <div class="clearfix"></div>
          <br />

          
        </div>
      </form>
    -->
