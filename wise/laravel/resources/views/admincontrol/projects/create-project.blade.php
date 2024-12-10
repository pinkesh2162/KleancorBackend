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
                        <form method="POST" novalidate action="{{ route('insertprojects') }}"
                            class="form-horizontal form-label-left">
                            @csrf
                            <span class="section">Create Project</span>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pname">Project Name<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{ old('pname') }}" id="pname"
                                        class="form-control col-md-7 col-xs-12" data-validate-length-range="6"
                                        data-validate-words="2" name="pname" required="required" type="text">
                                    @if ($errors->has('pname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('pname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="creBy">Company Name <span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="creBy" id="creBy" required="required"
                                        class="form-control col-md-7 col-xs-12">
                                        @foreach ($customerId as $item)
                                            <option value="{{ $item->id }}">{{ $item->company_name }} -
                                                {{ $item->contact_person }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('creBy'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('creBy') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Created Date

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
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="creBy">Customer Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="creBy" id="creBy" required="required" class="form-control col-md-7 col-xs-12">
                <option value="0">Select One</option>
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

                                    <input class="btn btn-primary" type="submit" value="Save" />
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
