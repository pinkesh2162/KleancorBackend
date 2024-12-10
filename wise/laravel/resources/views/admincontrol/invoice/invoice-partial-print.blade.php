<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title>Invoice</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font: 14px/1.4 Helvetica, Arial, sans-serif;
        }

        #page-wrap {
            width: 800px;
            margin: 0 auto;
        }

        textarea {
            border: 0;
            font: 14px Helvetica, Arial, sans-serif;
            overflow: hidden;
            resize: none;
        }

        table {
            border-collapse: collapse;
        }

        table td,
        table th {
            border: 1px solid black;
            padding: 5px;
        }

        #header {
            height: 15px;
            width: 100%;
            margin: 20px 0;
            background: #222;
            text-align: center;
            color: white;
            font: bold 15px Helvetica, Sans-Serif;
            text-decoration: uppercase;
            letter-spacing: 20px;
            padding: 8px 0px;
        }

        #address {
            width: 250px;
            height: 150px;
            float: left;
        }

        #customer {
            overflow: hidden;
        }

        #logo {
            text-align: right;
            float: right;
            position: relative;
            margin-top: 25px;
            border: 1px solid #fff;
            max-width: 540px;
            overflow: hidden;
        }

        #customer-title {
            font-size: 20px;
            font-weight: bold;
            float: left;
        }

        #meta {
            margin-top: 1px;
            width: 100%;
            float: right;
        }

        #meta td {
            text-align: right;
        }

        #meta td.meta-head {
            text-align: left;
            background: #eee;
            width: 120px;
        }

        #meta td textarea {
            width: 100%;
            height: 20px;
            text-align: right;
        }

        #items {
            clear: both;
            width: 100%;
            margin: 30px 0 0 0;
            border: 1px solid black;
        }

        #items th {
            background: #eee;
        }

        #items textarea {
            width: 80px;
            height: 50px;
        }

        #items tr.item-row td {
            vertical-align: top;
        }

        #items td.description {
            width: 300px;
        }

        #items td.item-name {
            width: 175px;
        }

        #items td.description textarea,
        #items td.item-name textarea {
            width: 100%;
        }

        #items td.total-line {
            border-right: 0;
            text-align: right;
        }

        #items td.total-value {
            border-left: 0;
            padding: 10px;
        }

        #items td.total-value textarea {
            height: 20px;
            background: none;
        }

        #items td.balance {
            background: #eee;
        }

        #items td.blank {
            border: 0;
        }

        #terms {
            margin: 15px 0 0 0;
            text-align: center;
        }

        #terms h5 {
            text-transform: capitalize;
            text-align: left;
            font: 14px Helvetica, Sans-Serif;
            border-bottom: 1px solid black;
            padding: 0 0 12px 0;
            margin: 0 0 8px 0;
        }

        #terms textarea {
            width: 100%;
            text-align: center;
        }



        .delete-wpr {
            position: relative;
        }

        .delete {
            display: block;
            color: #000;
            text-decoration: none;
            position: absolute;
            background: #EEEEEE;
            font-weight: bold;
            padding: 0px 3px;
            border: 1px solid;
            top: -6px;
            left: -22px;
            font-family: Verdana;
            font-size: 12px;
        }

        select {
            padding: 7px 15px 7px 2px;
        }

        input[type='submit'] {
            padding: 7px 15px;
        }

        /* Extra CSS for Print Button*/
        .button {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            overflow: hidden;
            margin-top: 20px;
            padding: 12px 12px;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-transition: all 60ms ease-in-out;
            transition: all 60ms ease-in-out;
            text-align: center;
            white-space: nowrap;
            text-decoration: none !important;

            color: #fff;
            border: 0 none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            line-height: 1.3;
            -webkit-appearance: none;
            -moz-appearance: none;

            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 160px;
            -ms-flex: 0 0 160px;
            flex: 0 0 160px;
        }

        .button:hover {
            -webkit-transition: all 60ms ease;
            transition: all 60ms ease;
            opacity: .85;
        }

        .button:active {
            -webkit-transition: all 60ms ease;
            transition: all 60ms ease;
            opacity: .75;
        }

        .button:focus {
            outline: 1px dotted #959595;
            outline-offset: -4px;
        }

        .button.-regular {
            color: #202129;
            background-color: #edeeee;
        }

        .button.-regular:hover {
            color: #202129;
            background-color: #e1e2e2;
            opacity: 1;
        }

        .button.-regular:active {
            background-color: #d5d6d6;
            opacity: 1;
        }

        .button.-dark {
            color: #FFFFFF;
            background: #333030;
        }

        .button.-dark:focus {
            outline: 1px dotted white;
            outline-offset: -4px;
        }

        @media print {

            .no-print,
            .no-print *,
            .salary-print-preview {
                display: none !important;
            }
        }

        #subtotal,
        .grand_total {
            float: right;
        }

        .search-bar {
            width: 100%;
            overflow-x: auto;
        }
    </style>

    <link href="{{ asset('datetime/css/jquery-ui-timepicker-addon.css') }}" rel="stylesheet">

    <script src='http://code.jquery.com/jquery-1.11.1.min.js'></script>
    <script src="https://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
    <script src="{{ asset('datetime/js/jquery-ui-timepicker-addon.js') }}"></script>
</head>

<body>

    <div id="page-wrap">

        <table width="100%">
            <tr>
                <td style="border: 0;  text-align: left" width="45%">
                    <a href="{{ route('dashboard') }}"><img id="image" src="{{ url('images/logo.png') }}"
                            alt="logo" /></a>
                    <br><br>

                </td>
                <td style="border: 0;  text-align: right" width="55%">
                    <div id="logo">
                        <p>TA-134/A, (2nd Floor) Boishakhi Shoroni,</p>
                        <p>Gulshan-Badda Link Road, Gulshan-1, Dhaka-1212</p>
                        <p>Tel: +8802-8833936, +8802-8833937</p>
                        <p>E-mail: wise.trade10@gmail.com</p>
                        <p>Web: www.wisetradebd.com</p>
                    </div>
                </td>
            </tr>
        </table>




        <div style="clear:both"></div>
        <div id="customer">
            <div class="search-bar no-print">
                <form action="" method="get">
                    <table class="table" width="100%">
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
                                <input type="text" autocomplete="off" name="start_date" class="form-control"
                                    id="start_date">
                            </td>
                            <td>
                                <label>End Date</label>
                                <input type="text" autocomplete="off" name="end_date" class="form-control"
                                    id="end_date">
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
            </div>
            @if (isset($allInvoice))
                <button class='button -dark center no-print' onClick="window.print();">Click Here to Print</button>
                @php
                    $i = 1;
                @endphp
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th style="width: 25%">Particulars</th>
                            <th style="width: 15%">Account</th>
                            <th style="width: 10%">Amount</th>
                            <th style="width: 10%">Invoice Date</th>
                            <th style="width: 10%">Due Date</th>
                            <th style="width: 5%">Status</th>
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
                                    {{ $value->subject }} <br />
                                    {{ $value->id }}/{{ $value->invoice_prefix }}
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

                            </tr>

                        </tbody>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <h4 class="pull-right" style="line-height: 30px; float: right">
                                    Total Amount: Taka
                                    {{ number_format($total->sales_amount + $total->sales_tax, 2) }}<br />
                                    Total Paid: Taka
                                    {{ number_format($total->tran_amount + $total->tran_tax + $total->tran_discount, 2) }}<br />
                                    Total Due: Taka
                                    {{ number_format($total->sales_amount + $total->sales_tax - ($total->tran_amount + $total->tran_tax + $total->tran_discount), 2) }}
                                </h4>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <br />
                <br />


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
        @endif


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
</body>



</html>
