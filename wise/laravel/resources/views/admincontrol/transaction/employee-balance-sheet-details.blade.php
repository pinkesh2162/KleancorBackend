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
                                <h4>{{ $employee->name }}'s Balance Sheet</h4>
                                <br>
                                <table class="table table-responsive table-striped table-hover table-bordered"
                                    style="width: 400px">
                                    <tr>
                                        <td>Total Credit:</td>
                                        <td>{{ number_format($totalCredit->total, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Credit:</td>
                                        <td>{{ number_format($totalDebit->total, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Return using salary:</td>
                                        <td>{{ number_format($salaryReturn->totalPaid, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Total Balance:</b></td>
                                        <td><b>{{ number_format($totalCredit->total - $totalDebit->total - $salaryReturn->totalPaid, 2) }}</b>
                                        </td>
                                    </tr>
                                </table>
                                <hr />
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label>Start Date</label>
                                            <input class="form-control" autocomplete="off" type="text" name="sdate"
                                                id="start_date">
                                        </div>
                                        <div class="col-sm-2">
                                            <label>End Date</label>
                                            <input class="form-control" autocomplete="off" type="text" name="edate"
                                                id="end_date">
                                        </div>
                                        <div class="col-sm-2">
                                            <label>&nbsp;</label>
                                            <input type="submit" class="form-control btn btn-info" name="search"
                                                value="Search">
                                        </div>
                                    </div>
                                </form>
                                <br />
                                <table class="table table-responsive table-striped table-hover table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <th>Purpose</th>
                                        <th>Total Credit</th>
                                        <th>Total Debit</th>
                                        <th>Balance</th>
                                    </tr>
                                    @php
                                        $totalCredit = 0;
                                        $totalDebit = 0;
                                        $prevTotalCredit = 0;
                                        $prevTotalDebit = 0;
                                    @endphp

                                    @foreach ($prevTotalCreditDebit as $dc)
                                        @if ($dc->type == 4)
                                            @php
                                                $prevTotalCredit += $dc->amount;
                                            @endphp
                                        @else
                                            @php
                                                $prevTotalDebit += $dc->amount;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @php
                                        $total = $prevTotalCredit - $prevTotalDebit;
                                    @endphp
                                    <tr style="color: #000; background: #e1e9ea;">
                                        <td colspan="2"><b>Balance Forward:</b></td>
                                        <td><b>Credit: </b>{{ number_format($prevTotalCredit, 2) }}</td>
                                        <td><b>Debit: </b>{{ number_format($prevTotalDebit, 2) }}</td>
                                        <td><b>Balance: </b>{{ number_format($prevTotalCredit - $prevTotalDebit, 2) }}</td>
                                    </tr>
                                    @foreach ($transaction as $tran)
                                        <tr>
                                            <td>{{ $tran->date }}</td>
                                            <td>{{ $tran->description }}</td>
                                            <td>
                                                @if ($tran->type == 4)
                                                    @php
                                                        $total += $tran->amount;
                                                        $totalCredit += $tran->amount;
                                                    @endphp
                                                    {{ $tran->amount }}
                                                @else
                                                    0
                                                @endif
                                            </td>
                                            <td>
                                                @if ($tran->type == 5)
                                                    @php
                                                        $total -= $tran->amount;
                                                        $totalDebit += $tran->amount;
                                                    @endphp
                                                    {{ $tran->amount }}
                                                @else
                                                    0
                                                @endif
                                            </td>
                                            <td>{{ $total }}</td>
                                        </tr>
                                    @endforeach

                                    <tr style="color: #000; background: #BEE5EB;">
                                        <td><b>Total Balance: </b></td>
                                        <td></td>
                                        <td>{{ number_format($totalCredit, 2) }}</td>
                                        <td>{{ number_format($totalDebit, 2) }}</td>
                                        <td><b>{{ number_format($totalCredit - $totalDebit, 2) }}</b></td>
                                    </tr>
                                </table>
                                {{ $transaction->links() }}
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
