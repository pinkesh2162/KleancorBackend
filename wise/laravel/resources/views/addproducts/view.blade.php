@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('addproduct.index') }}" class="btn btn-info">New Additional Products</a>
        <a href="{{ route('addproduct.view') }}" class="btn btn-success">Acitve Additional Products</a>
        <br /><br />
        <span class="section">{{ $title }}</span>
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

        <form action="" method="get">
            <table class="table">
                <tr>
                    <td width="200">
                        <label for="">Products</label>
                        <select class="form-control" name="pdtid">
                            <option value="0">All Product</option>
                            @foreach ($allPdt as $value)
                                <option value="{{ $value->id }}">{{ $value->title }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td width="200">
                        <label for="">Supplier</label>
                        <select class="form-control" name="customerid">
                            <option value="0">All Supplier</option>
                            @foreach ($customers as $value)
                                <option value="{{ $value->id }}">{{ $value->company_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td width="150">
                        <label for="">Payment Method</label>
                        <select class="form-control" name="paymethod_id">
                            <option value="0">Any Method</option>
                            <option value="1">Cash</option>
                            <option value="2">Due</option>
                            <option value="3">Cheque</option>
                        </select>
                    </td>
                    <td width="150">
                        <label for="">Start Date</label>
                        <input id="datepicker1" autocomplete="off" type="text" name="sdate" class="form-control">
                    </td>
                    <td width="150">
                        <label for="">End Date</label>
                        <input id="datepicker2" autocomplete="off" type="text" name="edate" class="form-control">
                    </td>
                    <td>
                        <label for="">&nbsp;</label>
                        <input type="submit" name="search" value="Search" class="btn btn-success form-control">
                    </td>
                </tr>
            </table>
        </form>
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 1%">Sl</th>
                    <th style="width: 17%">SKU</th>
                    <th>Product Name</th>
                    <th>Date</th>
                    <th>Purchase</th>
                    <th>Bank Name</th>
                    <th>Unit Amount</th>
                    <th>Total Amount</th>
                    <th>Cash Payment</th>
                    <th>Due Payment</th>
                    <th>Bank Payment</th>
                    @if (Auth::user()->type == 2)
                        <th>Edit / Delete</th>
                    @endif
                </tr>
            </thead>
            @php
                $installCheque = 0;
                $installCash = 0;
                $total = 0;
            @endphp
            @foreach ($newproduct as $item)
                <tbody>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>
                            <a href="{{ route('addproduct.status', $item->id) }}">{{ $item->sku }}</a>
                        </td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ sprintf('%0.2f', $item->stock) }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->amount }}</td>
                        <td>{{ $item->bank_amount + $item->due + $item->cash + $item->installCash + $item->installCheque }}
                        </td>
                        <td>{{ $item->cash + $item->installCash }}</td>
                        <td>{{ $item->due }}</td>
                        <td>{{ $item->bank_amount + $item->installCheque }}</td>
                        <td>
                            @if (Auth::user()->type == 2)
                                <a href="{{ route('addproduct.edit', $item->id) }}" class="btn btn-info btn-xs">
                                    <i class="fa fa-pencil"></i>
                                    Edit
                                </a>
                                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                    data-target="#myModal-{{ $item->id }}">
                                    <i class="fa fa-trash-o"></i> Delete
                                </button>
                            @endif
                        </td>
                        @php
                            $installCash += $item->installCash;
                            $installCheque += $item->installCheque;
                            $total +=
                                $item->bank_amount +
                                $item->due +
                                $item->cash +
                                $item->installCash +
                                $item->installCheque;
                        @endphp
                    </tr>
                </tbody>
                @php
                    $i++;
                @endphp
            @endforeach
            <tfoot>
                <tr>
                    <td colspan="9">
                        {!! $newproduct->appends(['pdtid' => $pdtid])->links() !!}
                    </td>
                    <td colspan="5">
                        <h4 class="pull-right" style="line-height: 26px; font-size: 16px; color: #000">
                            Total Amount: Taka {{ number_format($total, 2) }}<br>
                            Total Cash Paid: Taka {{ number_format($totalAmount->total_cash + $installCash, 2) }}<br>
                            Total Bank Paid: Taka
                            {{ number_format($totalAmount->total_bank_amount + $installCheque, 2) }}<br />
                            Total Due: Taka {{ number_format($totalAmount->total_due, 2) }}

                        </h4>
                    </td>
                </tr>
            </tfoot>
        </table>
        @foreach ($newproduct as $item)
            <!--------------------------------------------->
            <!-- Modal -->
            <div id="myModal-{{ $item->id }}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{ $item->title ?? 0 }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>Do you want to delete this?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <a href="{{ route('addproduct.delete', $item->id ?? 0) }}" class="btn btn-danger"><i
                                    class="fa fa-trash-o"></i>
                                Delete </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--------------------------------------------->
        @endforeach



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
            $("#datepicker1, #datepicker2").datepicker({
                minDate: new Date(2024, 6, 5),
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
            });
        });
    </script>
@endsection
