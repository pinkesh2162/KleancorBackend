@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <div class="col-sm-6">
                        <div class="bg-white">
                            <h4>Balance Sheet</h4>
                            <hr />
                            <table class="table table-responsive table-striped table-hover table-bordered">
                                <tr>
                                    <th>Description</th>
                                    <td align="right"><b>Amount</b></td>
                                </tr>
                                <?php
                                $totalAmount = 0;
                                foreach ($banks as $bank) {
                                    $totalDeposit = 0;
                                    $totalExpense = 0;
                                    $transferIn = 0;
                                    $transferOut = 0;
                                
                                    //Deposit
                                    foreach ($deposits as $value) {
                                        if ($value->bankid == $bank->id) {
                                            $totalDeposit += $value->tamount;
                                        }
                                    }
                                
                                    //Expense
                                    foreach ($expenses as $value) {
                                        if ($value->bankid == $bank->id) {
                                            $totalExpense += $value->tamount;
                                        }
                                    }
                                
                                    //Transfer In
                                    foreach ($transfers_in as $value) {
                                        if ($value->method == $bank->id) {
                                            $transferIn += $value->tamount;
                                        }
                                    }
                                
                                    //Transfer Out
                                    foreach ($transfers_out as $value) {
                                        if ($value->bankid == $bank->id) {
                                            $transferOut += $value->tamount;
                                        }
                                    }
                                
                                    echo '<tr>';
                                    echo "<td>{$bank->name}</td><td>";
                                    echo number_format($bank->balanch + $transferIn + $totalDeposit - ($transferOut + $totalExpense), 2);
                                    echo '</td></tr>';
                                
                                    $totalAmount += $bank->balanch + $transferIn + $totalDeposit - ($transferOut + $totalExpense);
                                }
                                ?>
                                <tr>
                                    <td colspan="2" align="right"><b style="font-size: 16px;">TOTAL:
                                            {{ number_format($totalAmount, 2) }}</b></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="bg-white">
                            <h4>Income/Expense Report</h4>
                            <hr />
                            <form action="" method="get">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Start Date</label>
                                        <input class="form-control" autocomplete="off" type="text" required
                                            name="sdate" id="start_date" value="{{ old('sdate') }}">
                                    </div>
                                    <div class="col-sm-4">
                                        <label>End Date</label>
                                        <input class="form-control" autocomplete="off" type="text" required
                                            name="edate" id="end_date" value="{{ old('edate') }}">
                                    </div>
                                    <div class="col-sm-4">
                                        <label>&nbsp;</label>
                                        <input type="submit" class="form-control btn btn-info" name="search"
                                            value="Search">
                                    </div>
                                </div>
                            </form>
                            @isset($income)
                                <table class="table table-responsive table-striped table-hover table-bordered">
                                    <tr>
                                        <th>Income</th>
                                        <td align="right">{{ number_format($income->eamount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Expense</th>
                                        <td align="right">{{ number_format($expense->eamount, 2) }}</td>
                                    </tr>
                                    <tr class="{{ $income->eamount - $expense->eamount > 0 ? 'green' : 'red' }}">
                                        <td colspan="2" align="right"><b style="font-size: 16px;">Summary:
                                                {{ number_format($income->eamount - $expense->eamount, 2) }}</b></td>
                                    </tr>
                                </table>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
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
@endsection
