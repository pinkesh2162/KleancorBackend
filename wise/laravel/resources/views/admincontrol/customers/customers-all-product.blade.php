@extends('layouts.app')

@section('content')
    <!--------------------------------------------->
    <!-- Trigger the modal with a button
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>
    -->

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

        <form action="" method="GET">
            <input type="text" name="sdate" id="datepicker" autocomplete="off">
            <input type="text" name="edate" id="datepicker2" autocomplete="off">
            <input type="submit" name="submit" value="Search">
        </form>
        <br>
        @php
            $i = 1;
            $price = 0;
            $quantity = 0;
            $totalTAmount = 0;
        @endphp

        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 1%">Sl</th>
                    <th>Products Title</th>
                    <th>Purchase Date</th>
                    <th>Price</th>
                    <th>Vat %</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            @foreach ($company as $item)
                <tbody>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>
                            {{ $item->pname }}
                        </td>
                        <td>
                            <a>{{ $item->adpDate }}</a>
                        </td>
                        <td>
                            {{ $item->price }} Tk
                        </td>
                        <td>
                            {{ $item->vat }}
                        </td>
                        <td>
                            <a>{{ $item->addstok }}</a>
                        </td>
                        <td>
                            @php
                                $total_vat = ($item->price * $item->addstok * $item->vat) / 100;
                                $totalprices = $item->price * $item->addstok + $total_vat;
                            @endphp
                            {{ $totalprices }} Tk
                        </td>
                    </tr>
                </tbody>
                @php
                    $i++;
                    $price += $item->price;
                    $quantity += $item->addstok;
                    $totalTAmount += $totalprices;
                @endphp
            @endforeach
            <tr>
                <thead>
                    <th style="border:none;"></th>
                    <th style="border:none;"></th>
                    <th style="border:none;"></th>
                    <th style="border:none;"></th>
                    <th style="border:none;float:right;margin-right:10px;">Total </th>
                    <th style="border:none;">{{ $quantity }}</th>
                    <th style="border:none;">{{ $totalTAmount }} Tk</th>
                </thead>
            </tr>
        </table>
        {!! $company->render() !!}


        @foreach ($company as $item)
            <!--------------------------------------------->
            <!-- Modal -->
            <div id="fridge-{{ $item->id }}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{ $item->company_name ?? 0 }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>Do you want to Fridge this?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <a href="{{ route('frozencustomers', $item->id ?? 0) }}" class="btn btn-danger"><i
                                    class="fa fa-trash-o"></i>
                                Fridge </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--------------------------------------------->
        @endforeach

        @foreach ($company as $item)
            <!--------------------------------------------->
            <!-- Modal -->
            <div id="myModal-{{ $item->id }}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{ $item->company_name ?? 0 }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>Do you want to delete this?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <a href="{{ route('deletecustomers', $item->id ?? 0) }}" class="btn btn-danger"><i
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

    <!-- Date Picker Script Start -->
    <script>
        $(function() {
            $("#datepicker").datepicker({
                minDate: new Date(2024, 6, 5),
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
            });
            $("#datepicker2").datepicker({
                minDate: new Date(2024, 6, 5),
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
            });
        });
    </script>
@endsection
