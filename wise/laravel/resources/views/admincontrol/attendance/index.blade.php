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

                        <form method="POST" action="{{ route('attendance.insert') }}"
                            class="form-horizontal form-label-left">
                            @csrf
                            <span class="section">Take Attendance</span>

                            <div class="item form-group">
                                <div class="col-md-7">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                        </tr>
                                        @foreach ($allEmp as $value)
                                            <tr>
                                                <td>{{ $value->name }}</td>
                                                <td>
                                                    <input type="hidden" name="ids[]" value="{{ $value->id }}">
                                                    <select class="form-control" name="status[{{ $value->id }}]">
                                                        <option value="1">Present</option>
                                                        <option value="2">Late</option>
                                                        <option value="3">Absent</option>
                                                        <option value="4">Leave</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Attendance Date

                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="datepicker" autocomplete="off" type="text" value="{{ old('date') }}"
                                        name="date" class="form-control col-md-7 col-xs-12" required>
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
