@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">

                    <div class="col-sm-12">
                        <div class="ibox-title">
                            <h5 style="display: inline-block">Invoice - 1654/EBL/ATM/12-2018, Chawk bazar EBL-365. </h5>
                            <input type="hidden" name="iid" value="978" id="iid">

                            <div class="btn-group  pull-right" role="group" aria-label="...">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn  btn-success btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-envelope-o"></i> Send Email
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#" id="mail_invoice_created">Invoice Created</a></li>
                                        <li><a href="#" id="mail_invoice_reminder">Invoice Payment Reminder</a></li>
                                        <li><a href="#" id="mail_invoice_overdue">Invoice Overdue Notice</a></li>
                                        <li><a href="#" id="mail_invoice_confirm">Invoice Payment Confirmation</a>
                                        </li>
                                        <li><a href="#" id="mail_invoice_refund">Invoice Refund Confirmation</a></li>
                                    </ul>
                                </div>

                                <div class="btn-group" role="group">
                                    <button type="button" class="btn  btn-primary btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i> Mark As
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#" id="mark_unpaid">Unpaid</a></li>
                                        <li><a href="#" id="mark_partially_paid">Partially Paid</a></li>
                                        <li><a href="#" id="mark_cancelled">Cancelled</a></li>

                                    </ul>
                                </div>

                                <button type="button" class="btn  btn-danger btn-sm" data-toggle="modal"
                                    data-target="#myModal"><i class="fa fa-plus"></i> Add Payment</button>
                                <a href="{{ route('invoice-pro.edit', $selected->id) }}" class="btn btn-warning  btn-sm"><i
                                        class="fa fa-pencil"></i> Edit</a>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn  btn-success btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false"><i class="fa fa-file-pdf-o"></i>
                                        PDF
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="https://accounts.wisetradebd.com/?ng=client/ipdf/978/token_3068418383/view/"
                                                target="_blank">View PDF</a></li>
                                        <li><a
                                                href="https://accounts.wisetradebd.com/?ng=client/ipdf/978/token_3068418383/dl/">Download
                                                PDF</a></li>
                                    </ul>
                                </div>
                                <a href="{{ route('invoice.print', $selected->id) }}" target="_blank"
                                    class="btn btn-primary  btn-sm"><i class="fa fa-print"></i> Print</a>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <p><img src="{{ url('/images/logo.png') }}" alt="" width="300"></p>
                            <h2 class="h2 mt-none mb-sm text-dark text-bold">INVOICE</h2>
                            <h4 class="h4 m-none text-dark text-bold">#1895/EBL/BRA/03-2019, Uday Tower 6th Floor. </h4>
                            @if ($selected->status == 1)
                                <h5 class="alert alert-success" style="background-color: #dff0d8; color: #34a263;">Paid</h5>
                            @else
                                <h5 class="alert alert-danger" style="background-color: #f2dede; color: red">Unpaid</h5>
                            @endif
                        </div>
                        <div class="col-sm-6 text-right">
                            <br />
                            <p>Zahir Mansion (3rd Floor) 476/C, D.I.T Road,</p>
                            <p>Malibagh, Dhaka-1217, Bangladesh.</p>
                            <p>Tel: +8802-49349420, Fax: +8802-78321233</p>
                            <p>E-mail: wise.trade10@gmail.com</p>
                            <p>Web: www.wisetradebd.com</p>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <h4>Bill For: {{ $selected->contact_person }}</h4>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-4">
                            <h4>Invoice To</h4>
                            <p>{{ $selected->company_name }}</p>
                            <p>{{ $selected->caddress }}</p>
                            <p>Phone: {{ $selected->contact_number }}</p>
                            <p>Email:{{ $selected->email }}</p>
                        </div>
                        <div class="col-sm-4">
                            <h4 editable="true">Delivery/Project</h4>
                            <p>Eastern Bank Limited</p>
                            <p>ATTN: Head of Admin</p>
                            <p>100 Gulshan Avenue.</p>
                            <p>Dhaka 1212</p>
                            <p>Bangladesh</p>
                            <p>Phone: 9556360</p>
                            <p>Email: rahmantau@ebl-bd.com</p>
                        </div>
                        <div class="col-sm-4">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Invoice/Date</th>
                                            <th style="text-align:right">{{ $selected->address }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Status</td>
                                            <td style="text-align:right">{{ $selected->status ? 'Paid' : 'Unpaid' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Chalan No./Date</td>
                                            <td style="text-align:right">{{ $selected->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <td>Due Date</td>
                                            <td style="text-align:right">{{ $selected->due_date }}</td>
                                        </tr>
                                        <tr>
                                            <td>Amount Due</td>
                                            <td style="text-align:right">
                                                {{ sprintf('%0.2f', $selected->amount + ($selected->amount * $selected->tax) / 100) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="text-align:center">Description</th>
                                        <th style="text-align:right">Unit Price</th>
                                        <th style="text-align:right">Qty/Unit</th>
                                        <th style="text-align:right">Total</th>
                                    </tr>
                                    @php $sTotal = 0 @endphp
                                    @foreach ($details as $key => $value)
                                        <tr>
                                            <td>{{ $value->title }}</td>
                                            <td style="text-align:right">Tk {{ sprintf('%0.2f', $value->price) }}</td>
                                            <td style="text-align:right">{{ $value->totalSale }} {{ $value->uname }}</td>
                                            <td style="text-align:right">Tk
                                                {{ sprintf('%0.2f', $value->price * $value->totalSale) }}</td>
                                        </tr>
                                        @php $sTotal += ($value->price * $value->totalSale) @endphp
                                    @endforeach
                                    <tr>
                                        <td rowspan="3"></td>
                                        <td colspan="3" align="right">
                                            Sub total: {{ sprintf('%0.2f', $sTotal) }}

                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2"></td>
                                        <td colspan="3" align="right">
                                            Tax: {{ $selected->tax }} %

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="right">Grand total:
                                            {{ sprintf('%0.2f', $sTotal + ($sTotal * $selected->tax) / 100) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align:left">In Words:
                                            {{ convertNumberToWord($sTotal + ($sTotal * $selected->tax) / 100) }} tk. only
                                        </td>
                                    </tr>
                                </table>
                                <p>Please pay the amount through Cheque/P.O/Cash in favour of Wise Trade</p>


                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-md">
            <form class="" action="{{ route('invoice-pro.payment_save') }}" method="post">
                @csrf
                <input type="hidden" name="iid" value="{{ $selected->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Invoice #{{ $selected->id }}</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-responsive borderless">
                            <tr>
                                <td width="20%">Account</td>
                                <td><select class="form-control" name="bankid">
                                        <option value="0">Cash</option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                        @endforeach
                                    </select></td>
                            </tr>

                            <tr>
                                <td width="20%">Date</td>
                                <td><input type="text" name="date" value="{{ date('Y-m-d') }}"
                                        class="form-control" id="datepicker"></td>
                            </tr>

                            <tr>
                                <td width="20%">Description</td>
                                <td><input type="text" name="description" required class="form-control"></td>
                            </tr>

                            <tr>
                                <td width="20%">Amount</td>
                                <td><input type="number" required value="{{ $selected->amount }}" name="amount"
                                        class="form-control"></td>
                            </tr>

                            <tr>
                                <td width="20%">Method</td>
                                <td>
                                    <select class="form-control" name="method">
                                        @foreach ($method as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="sub" value="Save" class="btn btn-success">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .borderless td,
        .borderless th {
            border: none !important;
        }
    </style>

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
@endsection
