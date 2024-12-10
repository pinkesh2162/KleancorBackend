@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <a href="{{ route('product') }}" class="btn btn-info">New Products</a>
                        <a href="{{ route('product.view') }}" class="btn btn-success">Acitve Products</a>
                        <br /><br />
                        <span class="section">New Products</span>

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

                        <form method="POST" action="{{ route('product.insert') }}" class="form-horizontal form-label-left">
                            @csrf


                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Title
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="name" value="{{ old('title') }}"
                                        class="form-control col-md-7 col-xs-12" data-validate-length-range="6"
                                        data-validate-words="2" name="title" type="text">
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea maxlength="255" id="name" rows="4" class="form-control col-md-7 col-xs-12"
                                        data-validate-length-range="6" data-validate-words="2" name="description" placeholder=" "></textarea>
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Unit Name</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <select class="select2_single form-control" tabindex="-1" name="units">

                                        @foreach ($units as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>


                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Created Date
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="datepicker" autocomplete="off" type="text" value="{{ old('old') }}"
                                        name="date" class="form-control col-md-7 col-xs-12">
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
