@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">

                    <div class="col-sm-12">
                        <div class="ibox-title">

                            <input type="hidden" name="iid" value="978" id="iid">

                            <div class="btn-group  pull-right" role="group" aria-label="...">
                                @if (!isset($top_sheet))
                                    @if (isset($transaction))
                                        @foreach ($transaction as $tran)
                                            <button class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#myEditModal-{{ $tran->id }}">
                                                Edit - {{ $tran->amount + $tran->tax + $tran->vat + $tran->discount }}
                                            </button>
                                        @endforeach
                                    @endif

                                    @if ($selected->status != 1)
                                        <button type="button" class="btn  btn-success btn-sm" data-toggle="modal"
                                            data-target="#myModal"><i class="fa fa-plus"></i> Add Payment</button>
                                    @endif
                                    @if (Auth::user()->type == 2)
                                        <a href="{{ route('invoice.edit', $selected->id) }}"
                                            class="btn btn-warning  btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                                    @endif
                                @endif
                                <a href="{{ route('invoice.print', $selected->id) }}" target="_blank"
                                    class="btn btn-primary  btn-sm"><i class="fa fa-print"></i> Print</a>


                            </div>

                        </div>

                        <div class="col-sm-6">
                            <p><img src="{{ url('/images/logo.png') }}" alt="" width="300"></p>
                            @if ($selected->status == 1)
                                <h5 class="alert alert-success" style="background-color: #dff0d8; color: #34a263;">Paid</h5>
                            @elseif ($selected->status == 2)
                                <h5 class="alert alert-warning" style="color: #FFF;">Partial Payment</h5>
                            @else
                                <h5 class="alert alert-danger" style="background-color: #f2dede; color: red">Unpaid</h5>
                            @endif
                            @if (session('msg'))
                                <h5 class="alert alert-success">
                                    {{ session('msg') }}
                                </h5>
                            @endif
                        </div>
                        <div class="col-sm-6 text-right">
                            <br />
                            <p>TA-134/A, (2nd Floor) Boishakhi Shoroni,</p>
                            <p>Gulshan-Badda Link Road, Gulshan-1, Dhaka-1212</p>
                            <p>Tel: +8802-8833936, +8802-8833937</p>
                            <p>E-mail: wise.trade10@gmail.com</p>
                            <p>Web: www.wisetradebd.com</p>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <h4>Bill For: {{ $selected->subject }}</h4>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-4">
                            <h4>Invoice To</h4>
                            <p>{{ $selected->company_name }}</p>
                            <p>{{ $selected->caddress }}</p>
                            <p>Attention: <b>{{ $selected->contact_person }}</b></p>
                            <p>Designation: {{ $selected->designation }}</p>
                            <p>Phone: {{ $selected->contact_number }}</p>
                            <p>Email:{{ $selected->email }}</p>
                        </div>
                        <div class="col-sm-4">
                            <h4 editable="true">Delivery/Project</h4>
                            <p>{!! nl2br($selected->address) !!}</p>
                        </div>
                        <div class="col-sm-4">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Invoice/Date</th>
                                            <th style="text-align:right">
                                                {{ $selected->id }}/{{ $selected->invoice_prefix }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Status</td>
                                            <td style="text-align:right">
                                                @if ($selected->status == 1)
                                                    Paid
                                                @elseif($selected->status == 2)
                                                    Partial Payment
                                                @else
                                                    Unpaid
                                                @endif
                                            </td>
                                        </tr>
                                        @if ($selected->status == 2)
                                            <tr style="background-color: #00A9A5; color: #FFF">
                                                <td>Amount Due</td>
                                                <td style="text-align:right">
                                                    {{ $selected->amount - ($paidAmount->total_paid + $paidAmount->total_tax + $paidAmount->total_vat + $paidAmount->total_discount) }}
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>Challan no. & Date</td>
                                            <td>
                                                @php
                                                    $challan = explode('####', $selected->challan);
                                                @endphp
                                                <table border='1' width="100%">
                                                    @foreach ($challan as $cha)
                                                        @php
                                                            $cha_details = explode('||||', $cha);
                                                        @endphp
                                                        <tr>
                                                            <td style="padding: 5px;">{{ substr($cha_details[0], 2) }}</td>
                                                            <td style="padding: 5px;">{{ $cha_details[1] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Work/Purchase Order</td>
                                            <td style="text-align:right">{{ $selected->work_order }}</td>
                                        </tr>

                                        <tr>
                                            <td>Due Date</td>
                                            <td style="text-align:right">{{ $selected->due_date }}</td>
                                        </tr>
                                        <tr>
                                            <td>Amount Due</td>
                                            <td style="text-align:right">TK.
                                                {{ number_format($selected->amount + ($selected->amount * $selected->tax) / 100, 2) }}
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
                                        <th style="text-align:right; width: 100px">Unit Price</th>
                                        <th style="text-align:right; width: 100px;">Qty/Unit</th>
                                        <th style="text-align:right; width: 120px;">Total</th>
                                    </tr>
                                    @php $sTotal = 0 @endphp
                                    @if ($details)
                                        @foreach ($details as $key => $value)
                                            <tr>
                                                <td>{{ $value->title }}{!! $value->ssd_description ? " $value->ssd_description" : '' !!}</td>
                                                <td style="text-align:right">Tk {{ number_format($value->price, 2) }}</td>
                                                <td style="text-align:right">
                                                    {{ $value->quantity1 != ceil($value->quantity1) ? number_format($value->quantity1, 2) : $value->quantity1 }}
                                                    {{ $value->uname }}</td>
                                                <td style="text-align:right">Tk
                                                    {{ number_format($value->price * $value->quantity1, 2) }}
                                                </td>
                                            </tr>
                                            @php $sTotal += ($value->price * $value->quantity1) @endphp
                                        @endforeach
                                    @endif

                                    @if ($allService)
                                        @foreach ($allService as $key => $value)
                                            <tr>
                                                <td>{{ $value->title }}</td>
                                                <td style="text-align:right">Tk {{ number_format($value->amount, 2) }}</td>
                                                <td style="text-align:right">{{ $value->quantity }} {{ $value->type }}
                                                </td>
                                                <td style="text-align:right">Tk
                                                    {{ number_format($value->amount * $value->quantity, 2) }}
                                                </td>
                                            </tr>
                                            @php $sTotal += ($value->amount * $value->quantity) @endphp
                                        @endforeach
                                    @endif

                                    <tr>
                                        <td rowspan="4"></td>
                                        <td colspan="3" align="right">
                                            Sub total: Tk. {{ number_format($sTotal, 2) }}

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="right">
                                            VAT & AIT: {{ $selected->tax }} %

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="right">
                                            Discount: Tk. {{ number_format($selected->discount, 2) }}

                                        </td>
                                    </tr>
                                    @php
                                        $sTotal -= $selected->discount;
                                    @endphp
                                    <tr>
                                        <td colspan="3" align="right">Grand total: Tk.
                                            {{ number_format(round($sTotal + ($sTotal * $selected->tax) / 100), 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align:left">In Words: Taka
                                            {{ ucwords(convertNumberToWord($sTotal + ($sTotal * $selected->tax) / 100)) }}
                                            only </td>
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
            <form class="" action="{{ route('invoice.payment_save') }}" method="post">
                @csrf
                <input type="hidden" name="iid" value="{{ $selected->id }}">
                <input type="hidden" name="total_amount" value="{{ $selected->amount }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">
                            @php
                                $partialPayment = 0;
                            @endphp
                            Invoice #{{ $selected->id }}, &nbsp;&nbsp;&nbsp;
                            Grand total: {{ $selected->amount }}
                            @if (isset($paidAmount->total_paid) && $paidAmount->total_paid > 0)
                                , &nbsp;&nbsp;&nbsp;Partial Payment: {{ $paidAmount->total_paid }}
                                @php
                                    $partialPayment = $paidAmount->total_paid;
                                @endphp
                            @endif
                        </h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-responsive borderless">
                            <tr>
                                <td width="20%">Payment Type</td>
                                <td>
                                    <select class="form-control" name="status">
                                        <option value="1">Full Payment</option>
                                        <option value="2">Partial Payment</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">Account</td>
                                <td><select class="form-control" name="bankid">
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
                                <td><input type="text" name="description" value="" required
                                        class="form-control">
                                </td>
                            </tr>

                            <tr>
                                <td width="20%">Amount</td>
                                <td><input type="text" name="amount" required
                                        value="{{ $selected->amount - $partialPayment }}" class="form-control"></td>
                            </tr>

                            <tr>
                                <td width="20%">Tax</td>
                                <td><input type="number" name="tax" value="0" class="form-control"></td>
                            </tr>

                            <tr>
                                <td width="20%">Vat</td>
                                <td><input type="number" name="vat" value="0" class="form-control"></td>
                            </tr>

                            <tr>
                                <td width="20%">Discount</td>
                                <td><input type="number" name="discount" value="0" class="form-control"></td>
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

    @if (isset($transaction))
        @foreach ($transaction as $tran)
            <div class="modal fade" id="myEditModal-{{ $tran->id }}" role="dialog">
                <div class="modal-dialog modal-md">

                    <form class="" action="{{ route('invoice.payment_update') }}" method="post">
                        @csrf
                        <input type="hidden" name="tranId" value="{{ $tran->id }}">
                        <input type="hidden" name="iid" value="{{ $selected->id }}">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">
                                    @php
                                        $partialPayment = 0;
                                    @endphp
                                    Invoice #{{ $selected->id }}, &nbsp;&nbsp;&nbsp;
                                    Grand total: {{ $selected->amount }}
                                    @if (isset($paidAmount->total_paid) && $paidAmount->total_paid > 0)
                                        , &nbsp;&nbsp;&nbsp;Partial Payment:
                                        {{ $paidAmount->total_paid + $paidAmount->total_vat + $paidAmount->total_tax + $paidAmount->total_discount }}
                                        @php
                                            $partialPayment = $paidAmount->total_paid;
                                        @endphp
                                    @endif
                                </h4>
                            </div>
                            <div class="modal-body">

                                <table class="table table-responsive borderless">
                                    <tr>
                                        <td></td>
                                        <td><a href="{{ route('invoice.payment.delete', $tran->id) }}"
                                                class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this payment?');">Delete
                                                Payment</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Payment Type</td>
                                        <td>
                                            <select class="form-control" name="status">
                                                <option value="1">Full Payment</option>
                                                <option value="2" {{ $selected->status == 2 ? 'selected' : '' }}>
                                                    Partial Payment</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Account</td>
                                        <td><select class="form-control" name="bankid">
                                                @foreach ($banks as $bank)
                                                    @if ($tran->bankid == $bank->id)
                                                        <option selected value="{{ $bank->id }}">{{ $bank->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select></td>
                                    </tr>

                                    <tr>
                                        <td width="20%">Date</td>
                                        <td><input type="text" name="date" value="{{ $tran->date }}"
                                                class="form-control" id="datepicker">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width="20%">Description</td>
                                        <td><input type="text" name="description" value="{{ $tran->description }}"
                                                required class="form-control"></td>
                                    </tr>

                                    <tr>
                                        <td width="20%">Amount</td>
                                        <td><input type="text" name="amount" required value="{{ $tran->amount }}"
                                                class="form-control">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width="20%">Tax</td>
                                        <td><input type="number" name="tax" value="{{ $tran->tax }}"
                                                class="form-control"></td>
                                    </tr>

                                    <tr>
                                        <td width="20%">Vat</td>
                                        <td><input type="number" name="vat" value="{{ $tran->vat }}"
                                                class="form-control"></td>
                                    </tr>

                                    <tr>
                                        <td width="20%">Discount</td>
                                        <td><input type="number" name="discount" value="{{ $tran->discount }}"
                                                class="form-control"></td>
                                    </tr>

                                    <tr>
                                        <td width="20%">Method</td>
                                        <td>
                                            <select class="form-control" name="method">
                                                @foreach ($method as $key => $value)
                                                    @if ($tran->method == $key)
                                                        <option selected value="{{ $key }}">{{ $value }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" name="Update" value="Update" class="btn btn-success">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endif

    <style>
        .borderless td,
        .borderless th {
            border: none !important;
        }
    </style>

    <script>
        $(document).ready(function() {
            $("body").on('click', "input[name='sub']", function(event) {
                var total_amount = Number($("input[name='total_amount']").val());
                var amount = Number($("input[name='amount']").val());
                var tax = Number($("input[name='tax']").val());
                var vat = Number($("input[name='vat']").val());
                var discount = Number($("input[name='discount']").val());
                var paidAmount = <?php echo $partialPayment; ?>

                if ($("select[name='status']").val() == "1") {
                    if (total_amount != (amount + tax + vat + discount + paidAmount)) {
                        event.preventDefault();
                        alert("Amount not match with total amount");
                    }
                }
            });
        });

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
