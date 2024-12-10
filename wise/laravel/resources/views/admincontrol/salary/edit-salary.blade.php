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
            <form method="POST" action="{{ route('updatesalary',$salary->id) }}" class="form-horizontal form-label-left">
              @csrf
              <span class="section">Create Salary</span>

              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="empName">Employee Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="empName" required="required" class="form-control col-md-7 col-xs-12" data-validate-length-range="6"
                  data-validate-words="2">
                  <option value="0">Select Name</option>
                  @foreach ($employee as $item)
                    <option {{ $salary->employeeid == $item->id ?'selected':'' }} value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('empName'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('empName') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Amount <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input value="{{ $salary->amount }}" type="text" id="amount" name="amount" required="required" class="form-control col-md-7 col-xs-12">
                @if ($errors->has('amount'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('amount') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Overtime <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input value="{{ $salary->overtime }}" type="text" id="overtime" name="overtime" required="required" class="form-control col-md-7 col-xs-12">
                @if ($errors->has('overtime'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('overtime') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bonus">Bonus <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input value="{{ $salary->bonus }}" type="text" id="bonus" name="bonus" required="required" class="form-control col-md-7 col-xs-12">
                @if ($errors->has('bonus'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('bonus') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="penalty">Penalty <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input value="{{ $salary->penalty }}" type="text" id="penalty" name="penalty" required="required" class="form-control col-md-7 col-xs-12">
                @if ($errors->has('penalty'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('penalty') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">

                <a href="{{ route('viewsalary') }}" class="btn btn-primary" type="submit">Back </a>
                <input class="btn btn-info" type="submit" value="Update" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
