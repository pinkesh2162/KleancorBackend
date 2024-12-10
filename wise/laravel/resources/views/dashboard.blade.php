@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="dashboard_graph">

                    <div class="row x_title">
                        <div class="col-md-6">
                            <h3>Dashboard</h3>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div style="background: #2196F3; color: #FFF; padding: 15px 0; margin: 0 15px">
                            <?php
                            $total = 0;
                            $today_deposit = 0;
                            $today_expense = 0;
                            foreach ($banks as $value) {
                                $today_expense = 0;
                                $total_deposit = 0;
                                $tra_dep = 0;
                                $tra_exp = 0;
                            
                                ######### Deposit ###########
                                foreach ($allDepositAmount as $dpo) {
                                    if ($dpo->bankid == $value->id) {
                                        $total_deposit += $dpo->damount;
                                    }
                                }
                            
                                ######### Expense ###########
                                foreach ($allExpenseAmount as $expns) {
                                    if ($expns->bankid == $value->id) {
                                        $today_expense += $expns->eamount;
                                    }
                                }
                                $total += $value->balanch + $total_deposit - $today_expense;
                            }
                            $total += $allEmployeeCredit->eCredit - $allEmployeeDebit->eDebit;
                            ?>
                            <h3 align="center">Tk {{ number_format($total, 2) }}</h3>
                            <hr>
                            <p align="center">Net Worth</p>
                            <br /><br />
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="amount">Tk {{ number_format($incomeToday->eamount, 2) }}</td>
                                        <td>Income Today</td>
                                    </tr>
                                    <tr>
                                        <td class="amount">Tk {{ number_format($expenseToday->eamount, 2) }}</td>
                                        <td>Expense Today</td>
                                    </tr>
                                    <tr>
                                        <td class="amount">Tk {{ number_format($incomeThisMonth->eamount, 2) }}</td>
                                        <td>Income This Month</td>
                                    </tr>
                                    <tr>
                                        <td class="amount">Tk {{ number_format($expenseThisMonth->eamount, 2) }}</td>
                                        <td>Expense This Month</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h4>Balance Sheet</h4>
                        <table class="table table-responsive table-striped table-hover table-bordered">
                            <tr>
                                <th>Description</th>
                                <td align="right"><b>Amount</b></td>
                            </tr>
                            @php $total = 0; @endphp
                            @foreach ($banks as $value)
                                @php
                                    $dep = 0;
                                    $exp = 0;
                                    $tra_dep = 0;
                                    $tra_exp = 0;
                                @endphp
                                @foreach ($allDepositAmount as $dpo)
                                    @if ($dpo->bankid == $value->id)
                                        @php $dep = $dpo->damount @endphp
                                    @endif
                                @endforeach
                                @foreach ($allExpenseAmount as $expns)
                                    @if ($expns->bankid == $value->id)
                                        @php $exp = $expns->eamount @endphp
                                    @endif
                                @endforeach

                                <!-- Transfer Section Start -->
                                @foreach ($total_transfer as $trans)
                                    @if ($trans->method == $value->id)
                                        @php $tra_dep = $trans->tamount @endphp
                                    @endif
                                @endforeach

                                @foreach ($total_transfer as $trans)
                                    @if ($trans->bankid == $value->id)
                                        @php $tra_exp = $trans->tamount @endphp
                                    @endif
                                @endforeach
                                <!-- Transfer Section End -->
                                <tr>
                                    <td>{{ $value->name }}</td>
                                    <td align="right">
                                        {{ number_format($value->balanch + $dep + $tra_dep - ($tra_exp + $exp), 2) }}</td>
                                </tr>
                                @php
                                    $total += $value->balanch + $dep + $tra_dep - ($tra_exp + $exp);
                                @endphp
                            @endforeach
                            <tr>
                                <td colspan="2" align="right"><b style="font-size: 16px;">TOTAL:
                                        {{ number_format($total, 2) }}</b></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-4">
                        <h4>Invoice</h4>
                        <table class="table table-responsive table-striped table-hover table-bordered">
                            <tr>
                                <td>Total Invoice</td>
                                <td>{{ $invoiceSummary->pending + $invoiceSummary->paid }}</td>
                            </tr>
                            <tr>
                                <td>Paid Invoice</td>
                                <td>{{ $invoiceSummary->paid }}</td>
                            </tr>
                            <tr>
                                <td>Pending Invoice</td>
                                <td>{{ $invoiceSummary->pending }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

        </div>
        <br />

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel tile">
                    <div class="x_title">
                        <h2>Invoice Due Tomorrow</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-striped projects">
                            <thead>
                                <tr>
                                    <th style="width: 25%">Particulars</th>
                                    <th>Account</th>
                                    <th style="width: 10%">Amount</th>
                                    <th style="width: 10%">Invoice Date</th>
                                    <th style="width: 10%">Due Date</th>
                                    <th style="width: 5%">Status</th>
                                    <th style="width: 25%; text-align: center">Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_due = 0;
                                    $total_paid = 0;
                                    $i = 0;
                                @endphp
                                @foreach ($dueTomorrow as $value)
                                    <tr>
                                        <td>
                                            <a href="{{ route('invoice.printPreview', $value->id) }}">
                                                {{ $value->subject }} <br />
                                                {{ $value->id }}/{{ $value->invoice_prefix }}
                                            </a>
                                        </td>
                                        <td> {{ $value->company_name }}<br />
                                            {{ $value->contact_person }}
                                        </td>
                                        <td>TK. {{ number_format($value->amount, 2) }}</td>
                                        <td>
                                            {{ $value->created_at }}
                                        </td>
                                        <td>{{ $value->due_date }}</td>
                                        <td>{!! $value->status
                                            ? '<span class="label label-success">Paid</span>'
                                            : '<span class="label label-danger">Unpaid</span>' !!}</td>
                                        <td class="text-right d-print-none">
                                            <a href="{{ route('invoice.printPreview', $value->id) }}"
                                                class="btn btn-primary btn-xs"><i class="fa fa-check"></i> View</a>
                                            <a href="{{ route('invoice.edit', $value->id) }}"
                                                class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                                            @if (Auth::user()->type == 2)
                                                <a href="{{ route('invoice.delete', $value->id) }}"
                                                    class="btn btn-danger btn-xs"
                                                    onclick="return confirm('Are you want to delete this?');"><i
                                                        class="fa fa-trash"></i>
                                                    Delete</a>
                                            @endif
                                        </td>
                                    </tr>

                                    @php
                                        $i++;
                                        $total_due += $value->amount;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <h4 class="pull-right" style="line-height: 30px">
                                            Total Due Amount: Taka {{ number_format($total_due, 2) }}
                                        </h4>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="x_panel tile">
                    <div class="x_title">
                        <h2>Invoice Due This Weeks</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 25%">Particulars</th>
                                    <th>Account</th>
                                    <th style="width: 10%">Amount</th>
                                    <th style="width: 10%">Invoice Date</th>
                                    <th style="width: 10%">Due Date</th>
                                    <th style="width: 5%">Status</th>
                                    <th style="width: 25%; text-align: center">Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_due = 0;
                                    $total_paid = 0;
                                    $i = 0;
                                @endphp
                                @foreach ($dueThisWeeks as $value)
                                    <tr>
                                        <td>
                                            <a href="{{ route('invoice.printPreview', $value->id) }}">
                                                {{ $value->subject }} <br />
                                                {{ $value->id }}/{{ $value->invoice_prefix }}
                                            </a>
                                        </td>
                                        <td> {{ $value->company_name }}<br />
                                            {{ $value->contact_person }}
                                        </td>
                                        <td>TK. {{ number_format($value->amount, 2) }}</td>
                                        <td>
                                            {{ $value->created_at }}
                                        </td>
                                        <td>{{ $value->due_date }}</td>
                                        <td>{!! $value->status
                                            ? '<span class="label label-success">Paid</span>'
                                            : '<span class="label label-danger">Unpaid</span>' !!}</td>
                                        <td class="text-right d-print-none">
                                            <a href="{{ route('invoice.printPreview', $value->id) }}"
                                                class="btn btn-primary btn-xs"><i class="fa fa-check"></i> View</a>
                                            <a href="{{ route('invoice.edit', $value->id) }}"
                                                class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                                            @if (Auth::user()->type == 2)
                                                <a href="{{ route('invoice.delete', $value->id) }}"
                                                    class="btn btn-danger btn-xs"
                                                    onclick="return confirm('Are you want to delete this?');"><i
                                                        class="fa fa-trash"></i>
                                                    Delete</a>
                                            @endif
                                        </td>
                                    </tr>

                                    @php
                                        $i++;
                                        $total_due += $value->amount;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <h4 class="pull-right" style="line-height: 30px">
                                            Total Due Amount: Taka {{ number_format($total_due, 2) }}
                                        </h4>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel tile">
                <div class="x_title">
                    <h2>Invoice Over Due</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 25%">Particulars</th>
                                <th>Account</th>
                                <th style="width: 10%">Amount</th>
                                <th style="width: 10%">Invoice Date</th>
                                <th style="width: 10%">Due Date</th>
                                <th style="width: 5%">Status</th>
                                <th style="width: 25%; text-align: center">Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_due = 0;
                                $total_paid = 0;
                                $i = 0;
                            @endphp
                            @foreach ($overDue as $value)
                                <tr>
                                    <td>
                                        <a href="{{ route('invoice.printPreview', $value->id) }}">
                                            {{ $value->subject }} <br />
                                            {{ $value->id }}/{{ $value->invoice_prefix }}
                                        </a>
                                    </td>
                                    <td> {{ $value->company_name }}<br />
                                        {{ $value->contact_person }}
                                    </td>
                                    <td>TK. {{ number_format($value->amount, 2) }}</td>
                                    <td>
                                        {{ $value->created_at }}
                                    </td>
                                    <td>{{ $value->due_date }}</td>
                                    <td>{!! $value->status
                                        ? '<span class="label label-success">Paid</span>'
                                        : '<span class="label label-danger">Unpaid</span>' !!}</td>
                                    <td class="text-right d-print-none">
                                        <a href="{{ route('invoice.printPreview', $value->id) }}"
                                            class="btn btn-primary btn-xs"><i class="fa fa-check"></i> View</a>
                                        <a href="{{ route('invoice.edit', $value->id) }}" class="btn btn-info btn-xs"><i
                                                class="fa fa-pencil"></i> Edit</a>
                                        @if (Auth::user()->type == 2)
                                            <a href="{{ route('invoice.delete', $value->id) }}"
                                                class="btn btn-danger btn-xs"
                                                onclick="return confirm('Are you want to delete this?');"><i
                                                    class="fa fa-trash"></i>
                                                Delete</a>
                                        @endif
                                    </td>
                                </tr>

                                @php
                                    $i++;
                                    $total_due += $value->amount;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    {{ $overDue->links() }}
                                    <h4 class="pull-right" style="line-height: 30px">
                                        Total Due Amount: Taka {{ number_format($overDueAmount->total_sales, 2) }}
                                    </h4>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
