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

                        <form method="GET" action="{{ route('attendance.view') }}"
                            class="form-horizontal form-label-left">
                            <span class="section">Attendance Report</span>
                            <div class="item form-group">
                                <div class="col-md-12">
                                    <table class="table table-striped">
                                        <tr>
                                            <td>
                                                Employee Name
                                                <select class="form-control" name="empid">
                                                    <option value="0">All Employee</option>
                                                    @foreach ($allEmp as $value)
                                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                Start Date
                                                <input id="datepicker" autocomplete="off" type="text"
                                                    value="{{ old('start_date') }}" name="start_date" class="form-control"
                                                    required>
                                            </td>
                                            <td>
                                                End Date
                                                <input id="datepicker2" autocomplete="off" type="text"
                                                    value="{{ old('end_date') }}" name="end_date" class="form-control">
                                            </td>
                                            <td><br /><input class="btn btn-primary" name="search" type="submit"
                                                    value="Search" /></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </form>

                        @if (isset($results) && $results)
                            <table class="table table-striped">
                                <tr>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    @if (Auth::user()->type == 2)
                                        <th>Action</th>
                                    @endif
                                </tr>
                                @php
                                    $overtime = 0;
                                    $present = 0;
                                    $late = 0;
                                    $absent = 0;
                                    $leave = 0;
                                @endphp
                                @foreach ($results as $result)
                                    <tr>
                                        <td>{{ $result->name }}</td>
                                        <td>{{ $result->created_at }}</td>
                                        <td>
                                            @if ($result->overtime)
                                                {{ $result->overtime == 1 ? 'Full Day' : 'Half Day' }}
                                                @php $overtime += $result->overtime @endphp
                                            @elseif ($result->status == 1)
                                                Present
                                                @php $present++ @endphp
                                            @elseif($result->status == 2)
                                                Late
                                                @php $late++ @endphp
                                            @elseif($result->status == 3)
                                                Absent
                                                @php $absent++ @endphp
                                            @elseif($result->status == 4)
                                                Leave
                                                @php $leave++ @endphp
                                            @endif
                                        </td>
                                        @if (Auth::user()->type == 2)
                                            <td>
                                                <a href="{{ $result->overtime ? route('attendance.overtimeEdit', $result->id) : route('attendance.edit', $result->id) }}"
                                                    class="btn btn-info btn-sm">Edit</a>
                                                <a href="{{ route('attendance.delete', $result->id) }}"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this?');">Delete</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4">
                                        <b>
                                            Total Present: {{ $present }}, &nbsp;&nbsp;
                                            Total Overtime: {{ $overtime }}, &nbsp;&nbsp;
                                            Total Late: {{ $late }}, &nbsp;&nbsp;
                                            Total Absent: {{ $absent }}, &nbsp;&nbsp;
                                            Total Leave: {{ $leave }}
                                        </b>
                                    </td>
                                </tr>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Picker Script Start -->
    <script>
        $(function() {
            $("#datepicker, #datepicker2").datepicker({
                minDate: new Date(2024, 6, 5),
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
            });
        });
    </script>
    <!-- Date Picker Script End -->

@endsection
