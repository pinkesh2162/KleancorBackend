@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('addproduct.index') }}" class="btn btn-info">New Additional Products</a>
        <a href="{{ route('addproduct.view') }}" class="btn btn-success">Acitve Additional Products</a>
        <a href="{{ route('addproduct.frozen') }}" class="btn btn-warning">Frozen Additional Products</a>
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
                    <td width="150">
                        <label for="">Start Date</label>
                        <input id="datepicker1" autocomplete="off" type="text" name="sdate" class="form-control">
                    </td>
                    <td width="150">
                        <label for="">End Date</label>
                        <input id="datepicker2" autocomplete="off" type="text" name="edate" class="form-control">
                    </td>
                    <td width="150">
                        <label for="">&nbsp;</label>
                        <input type="submit" name="search" value="Search" class="btn btn-success form-control">
                    </td>
                    <td></td>
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
                    <th>Sold</th>
                    <th>Stock</th>
                    <th>Bank Name</th>
                    <th>Unit Amount</th>
                    <th>Total Amount</th>
                    <th>Cash Payment</th>
                    <th>Due Payment</th>
                    <th>Bank Payment</th>
                </tr>
            </thead>
            <tbody>
                @isset($totalAmount2)
                    <tr>
                        <td colspan="13" align="right">
                            <h4 class="pull-right" style="line-height: 26px; font-size: 16px; color: #000">
                                B/F Amount: Taka {{ number_format($totalAmount2->total_amount, 2) }}<br>
                                B/F Total Cash Paid: Taka {{ number_format($totalAmount2->total_cash, 2) }}<br>
                                B/F Total Bank Paid: Taka {{ number_format($totalAmount2->total_bank_amount, 2) }}<br />
                                Current Dues: Taka {{ number_format($totalAmount2->total_due, 2) }}
                            </h4>
                        </td>
                    </tr>
                @endisset
                @foreach ($newproduct as $item)
                    <tr {!! $item->stock <= $item->totalSales1 + $item->totalSales2 ? "class='danger'" : '' !!}>
                        <td>{{ $i }}</td>
                        <td>
                            <a href="">{{ $item->sku }}</a>
                        </td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->stock }}</td>
                        <td>{{ $item->totalSales1 + $item->totalSales2 }}</td>
                        <td>{{ $item->stock - ($item->totalSales1 + $item->totalSales2) }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->amount }}</td>
                        <td>{{ $item->cash + $item->bank_amount + $item->due }}</td>
                        <td>{{ $item->cash }}</td>
                        <td>{{ $item->due }}</td>
                        <td>{{ $item->bank_amount }}</td>
                    </tr>

                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="9">
                        {!! $newproduct->appends(['pdtid' => $pdtid, 'sdate' => $sdate, 'edate' => $edate])->links() !!}
                    </td>
                    <td colspan="5">
                        <h4 class="pull-right" style="line-height: 26px; font-size: 16px; color: #000">
                            @isset($totalAmount2)
                                Balance Forward:
                                {{ number_format($totalAmount2->total_amount - $totalAmount2->total_cash - $totalAmount2->total_bank_amount, 2) }}
                                <br />
                            @else
                                Balance Forward: Taka 0.00 <br />
                            @endisset
                            Total Amount: Taka {{ number_format($totalAmount->total_amount, 2) }}<br>
                            Total Cash Paid: Taka {{ number_format($totalAmount->total_cash, 2) }}<br>
                            Total Bank Paid: Taka {{ number_format($totalAmount->total_bank_amount, 2) }}<br />
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
