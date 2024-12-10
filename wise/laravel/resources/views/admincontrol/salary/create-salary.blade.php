@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
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
                        <br>
                        <!-------------------->
                        <form action="{{ route('salary.add') }}" method="GET" class="form-inline">
                            <div class="form-group">
                                <label for="ex3">Year</label>
                                <select name="year" id="year" class="form-control year">
                                    <option value="0"> Select One</option>
                                    @php
                                        $year = date('Y');
                                        $year2 = 2017;
                                    @endphp
                                    @for ($i = 1; $year2 <= $year; $year--)
                                        <option value="{{ $year }}"> {{ $year }} </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Month</label>
                                <select name="month" id="month" class="form-control month">
                                    <option value="0">Select One</option>
                                    @php
                                        $month = 12;
                                    @endphp
                                    @for ($i = 1; $i <= $month; $month--)
                                        <option value="{{ $month }}"> {{ $month }}
                                        <option>
                                    @endfor
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span>
                                Search</button>
                        </form>
                        <!--------------------->
                        <br><br>


                        <form method="POST" action="{{ route('salary.create') }}" class="form-horizontal form-label-left">
                            @csrf
                            <span class="section">Panding Salary Of This Month</span>
                            @isset($nodata)
                                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">×</span>
                                    </button>
                                    <strong>

                                        {{ $nodata }}

                                    </strong>
                                </div>
                            @endisset
                            <br>
                            <table class="table table-striped projects">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th style="width: 20%">Employee Name</th>
                                        <th style="width: 12%">Designation</th>
                                        <th style="width: 10%">Amount</th>
                                        <th style="width: 10%">Over Time</th>
                                        <th style="width: 12%">Bonus</th>
                                        <th style="width: 12%">Advance</th>
                                        <th style="width: 12%">Employee Credit</th>
                                        <th style="width: 12%">Penalty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                @isset($employee)
                                    @foreach ($employee as $item)
                                        <tbody id="tbody">
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="status[]" value="{{ $item->empid }}"
                                                        checked />
                                                </td>
                                                <td>
                                                    {{ $item->empid }}
                                                    {{ $item->empname }}<br />
                                                    <small>P:{{ $item->present }}, OT:{{ $item->ot }}, A:
                                                        {{ $item->absent }}, L:{{ $item->late }}</small>
                                                </td>
                                                <td>
                                                    {{ $item->empdes }}
                                                </td>
                                                <td id="salary_{{ $item->empid }}">
                                                    {{ $item->empsalery }} Tk
                                                </td>
                                                <td id="ot_{{ $item->empid }}">
                                                    <input type="hidden"
                                                        value="{{ round(($item->empsalery / 30) * $item->ot) }}"
                                                        name="ot_{{ $item->empid }}" />
                                                    {{ round(($item->empsalery / 30) * $item->ot) }} Tk
                                                </td>
                                                <td>

                                                    <input value="0" type="text" id="bon_{{ $item->empid }}"
                                                        name="bonus_{{ $item->empid }}" required="required"
                                                        class="form-control col-md-7 col-xs-12 slaryStatement">
                                                    @if ($errors->has('bonus'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('bonus') }}</strong>
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $advance = 0;
                                                        //print_r($allAdvance);
                                                        foreach ($allAdvance as $adv) {
                                                            if ($adv->employee_id == $item->empid) {
                                                                $advance =
                                                                    ($adv->amount - $adv->advance) /
                                                                    ($adv->installment ? $adv->installment : 1);
                                                            }
                                                        }
                                                    @endphp
                                                    <input type="text" id="adv_{{ $item->empid }}"
                                                        name="adv_{{ $item->empid }}" value="{{ $advance }}"
                                                        class="form-control slaryStatement">
                                                </td>
                                                <td>
                                                    @php
                                                        $penalty = 0;
                                                        if ($item->late > 0) {
                                                            $late = floor($item->late / 3);
                                                            $penalty = round(($item->empsalery / 30) * $late);
                                                        }
                                                        if ($item->absent > 0) {
                                                            $penalty += round(($item->empsalery / 30) * $item->absent);
                                                        }
                                                    @endphp
                                                    <input value="{{ $penalty }}" type="text"
                                                        id="pen_{{ $item->empid }}" name="penalty_{{ $item->empid }}"
                                                        required="required"
                                                        class="form-control col-md-7 col-xs-12 slaryStatement">
                                                    @if ($errors->has('penalty'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('penalty') }}</strong>
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $emp_credit = 0;
                                                        $emp_debit = 0;
                                                        $emp_return = 0;
                                                    @endphp

                                                    @foreach ($allEmployeeCredit as $emp)
                                                        @if ($item->empid == $emp->employee_id)
                                                            @php
                                                                $emp_credit = $emp->eCredit;
                                                            @endphp
                                                        @endif
                                                    @endforeach

                                                    @foreach ($allEmployeeDebit as $emp)
                                                        @if ($item->empid == $emp->employee_id)
                                                            @php
                                                                $emp_debit = $emp->eDebit;
                                                            @endphp
                                                        @endif
                                                    @endforeach

                                                    @foreach ($allReturn as $emp)
                                                        @if ($item->empid == $emp->employeeid)
                                                            @php
                                                                $emp_return = $emp->totalPaid;
                                                            @endphp
                                                        @endif
                                                    @endforeach

                                                    @php
                                                        $totalCredit = $emp_credit - $emp_debit - $emp_return;
                                                    @endphp

                                                    <input value="{{ $totalCredit }}" type="text"
                                                        id="cre_{{ $item->empid }}" name="cre_{{ $item->empid }}"
                                                        required="required"
                                                        class="form-control col-md-7 col-xs-12 slaryStatement">

                                                </td>
                                                <td>
                                                    <b class="TotalSalery" id="total_{{ $item->empid }}">
                                                        {{ $item->empsalery +
                                                            round(($item->empsalery / 30) * $item->ot) -
                                                            round(($item->empsalery / 30) * $item->absent) -
                                                            $advance -
                                                            $totalCredit }}
                                                    </b>Tk
                                                </td>
                                            </tr>
                                        </tbody>
                                    @endforeach
                                    <input id="yearmonth" name="yearmonth" class="yearmonth" type="hidden"
                                        value="{{ Session::get('yearmonth') }}">
                                @endisset
                            </table>
                            <p>Note: Present: p, Absent: A and Late: L</p>
                            <input id="save" class="btn btn-primary pull-right" type="submit" value="Save"
                                style="margin-left:40px;" />

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $("body").on("input", ".slaryStatement", function() {
                //$('.slaryStatement').change(function () {
                var id = parseInt($(this).attr("id").substr(4));
                var salary = parseFloat($("#salary_" + id).text());
                var ot = parseFloat($("#ot_" + id).text());
                var bonus = parseFloat($("#bon_" + id).val());
                var adv = parseFloat($("#adv_" + id).val());
                var penalty = parseFloat($("#pen_" + id).val());
                var credit = parseFloat($("#cre_" + id).val());

                console.log('credit', credit)

                var total_salary = salary + ot + bonus - penalty - adv - credit;


                $("#total_" + id).text(total_salary);

            });
        });
    </script>
@endsection
