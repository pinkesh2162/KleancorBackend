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
                        <div class="col-sm-4">
                            <form method="POST" action="{{ route('transaction.transfer-store') }}"
                                class="form-horizontal form-label-left">
                                @csrf
                                <div class="bg-white">
                                    <h4>New Transfer</h4>
                                    <hr />
                                    <label>From</label>
                                    <select class="form-control" name="bankid">
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                        @endforeach
                                    </select><br />

                                    <label>To</label>
                                    <select class="form-control" name="method">
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                        @endforeach
                                    </select><br />

                                    <label>Date</label>
                                    <input type="text" name="date" value="{{ date('Y-m-d') }}" class="form-control"
                                        id="datepicker">
                                    <br />

                                    <label>Purpose</label>
                                    <input type="text" required name="description" value="{{ old('description') }}"
                                        class="form-control">
                                    <br />

                                    <label>Amount</label>
                                    <input type="text" required name="amount" value="{{ old('amount') }}"
                                        class="form-control">
                                    <br />
                                    <input type="submit" name="sub" value="Save" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-8">
                            <div class="bg-white">
                                <h4>Recent Transfer</h4>
                                <hr />
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label>Account</label>
                                            <select class="form-control" name="bankid">
                                                <option value="-1">All Account</option>
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
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
                                        <div class="col-sm-2">
                                            <label>&nbsp;</label>
                                            <a href="{{ route('transaction.transfer') }}"
                                                class="form-control btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </form>
                                <br />

                                <table class="table table-responsive table-striped table-hover table-bordered">
                                    <tr>
                                        <th>Date</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Description</th>
                                        <th width="150">Amount</th>
                                        @if (Auth::user()->type == 2)
                                            <th width="150">Action</th>
                                        @endif
                                    </tr>
                                    @isset($bf)
                                        <tr style="color: #000; background: #e1e9ea;">
                                            <td colspan="3" align="right"><b>Balance Forward</b></td>
                                            <td></td>
                                            <td><b>{{ number_format($bf, 2) }}</b></td>
                                            @if (Auth::user()->type == 2)
                                                <td></td>
                                            @endif
                                        </tr>
                                    @endisset
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach ($transaction as $key => $value)
                                        <tr>
                                            <td>{{ $value->date }}</td>
                                            <td>{{ $value->from_name }}</td>
                                            <td>{{ $value->to_name }}</td>
                                            <td>{{ $value->description }}</td>
                                            <td>{{ number_format($value->amount, 2) }}</td>
                                            @if (Auth::user()->type == 2)
                                                <td>
                                                    @if ($value->salesid)
                                                        {{ 'Invoice Payment' }}
                                                    @else
                                                        <a href="{{ route('transaction.edit-transfer', $value->id) }}"
                                                            class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                                                            Edit</a>
                                                        <a href="{{ route('transaction.delete-transfer', $value->id) }}"
                                                            class="btn btn-danger btn-xs"
                                                            onclick="return confirm('Are you want to delete this?');"><i
                                                                class="fa fa-trash"></i> Delete</a>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                        @isset($bf)
                                            @php
                                                $total += $value->amount;
                                            @endphp
                                        @endisset
                                    @endforeach

                                    @isset($bf)
                                        <tr style="color: #000; background: #BEE5EB;">
                                            <td colspan="3" align="right"><b>Total Balance: </b></td>
                                            <td></td>
                                            <td><b>{{ number_format($total + $bf, 2) }}</b></td>
                                            @if (Auth::user()->type == 2)
                                                <td></td>
                                            @endif
                                        </tr>
                                    @endisset
                                </table>
                            </div>
                            {{ $transaction->links() }}
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
