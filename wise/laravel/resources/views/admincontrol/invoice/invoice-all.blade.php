@extends('layouts.app')

@section('content')
    <div class="container">
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

        @php
            $i = 1;
        @endphp
        <h2>{{ $title }}</h2>
        <form class="" action="" method="get">
            <table class="table">
                <tr>
                    <td>
                        <label>Customers</label>
                        <select class="form-control" name="customerid">
                            <option value="0">All Customers</option>
                            @foreach ($customers as $cust)
                                <option value="{{ $cust->id }}">{{ $cust->company_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <label>Start Date</label>
                        <input type="text" autocomplete="off" name="start_date" class="form-control" id="start_date">
                    </td>
                    <td>
                        <label>End Date</label>
                        <input type="text" autocomplete="off" name="end_date" class="form-control" id="end_date">
                    </td>
                    <td>
                        <label>Status</label>
                        <select class="form-control" name="status">
                            <option value="-1">All Invoice</option>
                            <option value="1">Paid</option>
                            <option value="0">Unpaid</option>
                        </select>
                    </td>
                    <td>
                        <label for="">&nbsp;</label>
                        <input type="submit" name="search" value="Search" class="form-control btn btn-info">
                    </td>
                </tr>
            </table>
        </form>
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 25%">Particulars</th>
                    <th style="width: 15%">Account</th>
                    <th style="width: 10%">Amount</th>
                    <th style="width: 10%">Due</th>
                    <th style="width: 10%">Invoice Date</th>
                    <th style="width: 10%">Due Date</th>
                    <th style="width: 5%">Status</th>
                    <th>Manage</th>
                </tr>
            </thead>
            @php
                $total_due = 0;
                $total_paid = 0;
            @endphp
            @foreach ($allInvoice as $value)
                <tbody>
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
                            @if ($value->status == 1)
                                ---
                            @elseif($value->status == 2)
                                TK.
                                {{ number_format($value->amount - ($value->tr_amount + $value->tr_vat + $value->tr_tax), 2) }}
                            @else
                                TK. {{ number_format($value->amount, 2) }}
                            @endif
                        </td>
                        <td>
                            {{ $value->created_at }}
                        </td>
                        <td>{{ $value->due_date }}</td>
                        <td>
                            @if ($value->status == 1)
                                {!! '<span class="label label-success">Paid</span>' !!}
                            @elseif($value->status == 2)
                                {!! '<span class="label label-info">Partial payment</span>' !!}
                            @else
                                {!! '<span class="label label-danger">Unpaid</span>' !!}
                            @endif
                        <td class="text-right d-print-none">
                            <a href="{{ route('invoice.printPreview', $value->id) }}" class="btn btn-primary btn-xs"><i
                                    class="fa fa-check"></i> View</a>

                            @if (Auth::user()->type == 2)
                                <a href="{{ route('invoice.edit', $value->id) }}" class="btn btn-info btn-xs"><i
                                        class="fa fa-pencil"></i> Edit</a>
                                <a href="{{ route('invoice.delete', $value->id) }}" class="btn btn-danger btn-xs"
                                    onclick="return confirm('Are you want to delete this?');"><i class="fa fa-trash"></i>
                                    Delete</a>
                            @endif
                        </td>
                    </tr>

                </tbody>
                @php
                    $i++;
                @endphp
            @endforeach
            <tfoot>
                <tr>
                    <td colspan="7">
                        <h4 class="pull-right" style="line-height: 30px">
                            Total Amount: Taka {{ number_format($total->sales_amount + $total->sales_tax, 2) }}<br />
                            Total Paid: Taka
                            {{ number_format($total->tran_amount + $total->tran_tax + $total->tran_discount, 2) }}<br />
                            Total Due: Taka
                            {{ number_format($total->sales_amount + $total->sales_tax - ($total->tran_amount + $total->tran_tax + $total->tran_discount), 2) }}
                        </h4>
                    </td>
                </tr>
            </tfoot>
        </table>
        {{ $allInvoice->appends(['customerid' => 'customerid', 'start_date' => 'start_date', 'end_date' => 'end_date', 'status' => 'status'])->links() }}


        <!----------------------------------------->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $("#start_date, #end_date").datepicker({
                minDate: new Date(2024, 6, 5),
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
            });
        });
    </script>
@endsection
