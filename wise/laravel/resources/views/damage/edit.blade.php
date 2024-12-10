@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <a href="{{ route('damage.index') }}" class="btn btn-info">New Damage</a>
                        <a href="{{ route('damage.view') }}" class="btn btn-success">View Damage</a>
                        <br /><br />
                        <span class="section">Edit Damage</span>
                        <form method="POST" action="{{ route('damage.update', $selected->random_number) }}"
                            class="form-horizontal form-label-left">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Name<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="select2_single form-control" tabindex="-1" name="product">
                                        @foreach ($allProduct as $item)
                                            @if ($item->id == $selected->pid)
                                                <option selected value="{{ $item->id }}">{{ $item->title }}</option>
                                            @else
                                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Number of
                                    Damage<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{ $selected->original_damage }}" class="form-control col-md-7 col-xs-12"
                                        name="quantity" placeholder=" " required="required" type="text">
                                    @if ($errors->has('quantity'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Damage
                                    Reason</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="reason" class="form-control">{{ $selected->reason }}</textarea>
                                    @if ($errors->has('reason'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('reason') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Created Date<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="datepicker" autocomplete="off" type="text"
                                        value="{{ $selected->created_at }}" name="date"
                                        class="form-control col-md-7 col-xs-12" required>
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
                                    <input id="submit" class="btn btn-primary" type="submit" value="Update" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
