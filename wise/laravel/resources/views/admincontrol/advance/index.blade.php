@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
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

                        <form method="POST" action="{{ route('advance.insert') }}" class="form-horizontal form-label-left">
                            @csrf
                            <span class="section">{{ $title }}</span>

                            <div class="item form-group">
                                <div class="col-md-7">
                                    <label for="">Employee Name</label>
                                    <select class="form-control" name="employee_id">
                                        @foreach ($allEmp as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    <br />

                                    <label for="">Amount</label>
                                    <input type="text" name="amount" required min="1" value=""
                                        class="form-control">

                                    <br />
                                    <label for="">Number of Installment</label>
                                    <select class="form-control" name="installment">
                                        <option value="1">1 Installment</option>
                                        <option value="2">2 Installments</option>
                                        <option value="3">3 Installments</option>
                                        <option value="4">4 Installments</option>
                                        <option value="5">5 Installments</option>
                                        <option value="6">6 Installments</option>
                                        <option value="7">7 Installments</option>
                                        <option value="8">8 Installments</option>
                                        <option value="9">9 Installments</option>
                                        <option value="10">10 Installments</option>
                                        <option value="11">11 Installments</option>
                                        <option value="12">12 Installments</option>
                                    </select>

                                    <br />
                                    <input class="btn btn-primary" type="submit" value="Save" />
                                </div>

                            </div>


                        </form>
                    </div>
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
