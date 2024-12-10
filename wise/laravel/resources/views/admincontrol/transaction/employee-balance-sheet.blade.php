@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

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

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="bg-white">
                                <h4>Employee Balance Sheet</h4>
                                <hr />
                                <table class="table table-responsive table-striped table-hover table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <th>Total Credit</th>
                                        <th>Total Debit</th>
                                        <th>Salary Adjust</th>
                                        <th>Balance</th>
                                        <th>Details</th>
                                    </tr>
                                    @php
                                        $totalCredit = 0;
                                        $totalDebit = 0;
                                        $totalSalaryPaid = 0;
                                    @endphp
                                    @foreach ($employee as $emp)
                                        <tr>
                                            <td>
                                                {{ $emp->name }}
                                            </td>
                                            @php
                                                $subCredit = 0;
                                                $subDebit = 0;
                                                $subSalary = 0;
                                            @endphp

                                            @foreach ($creditTransaction as $tran)
                                                @if ($emp->id == $tran->employee_id)
                                                    @php
                                                        $subCredit = $tran->total;
                                                        $totalCredit += $tran->total;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            @foreach ($debitTransaction as $tran)
                                                @if ($emp->id == $tran->employee_id)
                                                    @php
                                                        $subDebit = $tran->total;
                                                        $totalDebit += $tran->total;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            @foreach ($salaryReturn as $tran)
                                                @if ($emp->id == $tran->employeeid)
                                                    @php
                                                        $subSalary = $tran->totalPaid;
                                                        $totalSalaryPaid += $tran->totalPaid;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            <td>{{ number_format($subCredit, 2) }}</td>
                                            <td>{{ number_format($subDebit, 2) }}</td>
                                            <td>{{ number_format($subSalary, 2) }}</td>
                                            <td>{{ number_format($subCredit - $subDebit - $subSalary, 2) }}</td>
                                            <td>
                                                <a href="{{ route('transaction.employee-balance-sheet-details', $emp->id) }}"
                                                    class="btn btn-success btn-xs">
                                                    Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr style="color: #000; background: #BEE5EB;">
                                        <td><b>Total Credit: </b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>{{ number_format($totalCredit, 2) }}</b></td>
                                        <td></td>
                                    </tr>
                                    <tr style="color: #000; background: #BEE5EB;">
                                        <td><b>Total Debit: </b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>{{ number_format($totalDebit, 2) }}</b></td>
                                        <td></td>
                                    </tr>
                                    <tr style="color: #000; background: #BEE5EB;">
                                        <td><b>Return using salary: </b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>{{ number_format($totalSalaryPaid, 2) }}</b></td>
                                        <td></td>
                                    </tr>
                                    <tr style="color: #000; background: #BEE5EB;">
                                        <td><b>Total Balance: </b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>{{ number_format($totalCredit - $totalDebit - $totalSalaryPaid, 2) }}</b>
                                        </td>
                                        <td></td>
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
            $("#datepicker, #start_date, #end_date").datepicker({
                minDate: new Date(2024, 6, 5),
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
            });
        });
    </script>
    <!-- Date Picker Script End -->
@endsection
