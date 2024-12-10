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

                    <form method="POST" action="{{ route('transaction.new-expense-update') }}"
                        class="form-horizontal form-label-left">
                        @foreach ($selected as $select)
                            @csrf
                            <input type="hidden" name="id" value="{{ $select->id }}">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="bg-white">
                                        <h4>Edit Expense</h4>
                                        <hr />
                                        <label>Account</label>
                                        <select class="form-control" name="bankid">
                                            @foreach ($banks as $bank)
                                                @if ($select->bankid == $bank->id)
                                                    <option selected value="{{ $bank->id }}">{{ $bank->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                @endif
                                            @endforeach
                                        </select><br />

                                        <label>Date</label>
                                        <input type="text" name="date" value="{{ $select->date }}"
                                            class="form-control" id="datepicker">
                                        <br />

                                        <label>Purpose</label>
                                        <input type="text" required name="description"
                                            value="{{ $select->description }}" class="form-control">
                                        <br />

                                        <label>Amount</label>
                                        <input type="text" required name="amount" value="{{ $select->amount }}"
                                            class="form-control">
                                        <br />

                                        <label>Payment Method</label>
                                        <select class="form-control" name="method">
                                            @foreach ($method as $key => $value)
                                                @if ($select->bankid == $key)
                                                    <option selected value="{{ $key }}">{{ $value }}
                                                    </option>
                                                @else
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endif
                                            @endforeach
                                        </select><br />

                                        <input type="submit" name="sub" value="Update" class="btn btn-success">

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Date Picker Script Start -->
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
    <!-- Date Picker Script End -->
@endsection
