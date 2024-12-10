@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
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

                        <span class="section">{{ $title }}</span>
                        <div class="item form-group">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Advance Amount</th>
                                        <th>Paid Amount</th>
                                    </tr>
                                    @php
                                        $totalAdvance = 0;
                                        $totalPaid = 0;
                                    @endphp
                                    @foreach ($allData as $key => $value)
                                        <tr>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->totalAdvance }}</td>
                                            <td>{{ $value->totalPaid }}</td>
                                        </tr>
                                        @php
                                            $totalAdvance += $value->totalAdvance;
                                            $totalPaid += $value->totalPaid;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="3" align="right">
                                            <p style="font-size: 16px; line-height: 26px;">
                                                Total Advanced: {{ $totalAdvance }} <br />
                                                Total Paid: {{ $totalPaid }}
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
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
