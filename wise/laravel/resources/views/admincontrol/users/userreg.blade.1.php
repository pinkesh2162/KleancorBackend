@extends('layouts.auth')

@section('content')

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
@endsection
