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

                        <form method="POST" action="{{ route('attendance.overtimeUpdate', $selected->id) }}"
                            class="form-horizontal form-label-left">
                            @csrf
                            <span class="section">Edit Overtime</span>

                            <div class="item form-group">
                                <div class="col-md-5">
                                    <table class="table table">
                                        <tr>
                                            <td>
                                                <label for="">Employee Name</label>
                                                <select class="form-control" name="employee_id">
                                                    @foreach ($allEmp as $value)
                                                        @if ($value->id == $selected->employee_id)
                                                            <option selected value="{{ $value->id }}">{{ $value->name }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="">Overtime Time</label>
                                                <select class="form-control" name="type">
                                                    <option value="1"{{ $selected->overtime == 1 ? ' selected' : '' }}>
                                                        Full Day</option>
                                                    <option value=".5"{{ $selected->overtime == 0.5 ? ' selected' : '' }}>
                                                        Half Day</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="">Date</label>
                                                <input id="datepicker" autocomplete="off" type="text"
                                                    value="{{ substr($selected->created_at, 0, 10) }}" name="date"
                                                    class="form-control" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input class="btn btn-primary" type="submit" value="Update" /></td>
                                        </tr>
                                    </table>
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
