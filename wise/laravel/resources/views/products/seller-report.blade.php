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
        <h3>Seller Report</h3>
        <div class="ln_solid"></div>
        <form action="" method="GET">
            <input type="text" name="sdate" id="datepicker" autocomplete="off" />
            <input type="text" name="edate" id="datepicker2" autocomplete="off" />
            <input type="submit" value="Search" name="search" />
        </form>
        @php
            $i = 1;
            $totalprice = 0;
            $totalstock = 0;
            $fullamount = 0;
        @endphp
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 1%">Sl</th>
                    <th>Customer Name</th>
                    <td>Purchase Date</td>
                    <th>Product Name</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Vat %</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            @foreach ($newproduct as $item)
                <tbody>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>
                            {{ $item->custoname }}
                        </td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->pname }}</td>
                        <td value="{{ $item->id }}">
                            @php($totalstock += $item->stock);
                            @endphp
                            {{ $item->stock }}
                        </td>
                        <td>
                            @php($totalprice += $item->price);
                            @endphp
                            {{ $item->price }}
                        </td>

                        <td>{{ $item->pvat }}</td>
                        <td>
                            @php
                                $totalvat = ($item->price * $item->stock * $item->pvat) / 100;
                                $totalamount = $item->price * $item->stock + $totalvat;
                                $fullamount += $totalamount;
                            @endphp
                            {{ $totalamount }}

                        </td>
                    </tr>
                </tbody>
                @php
                    $i++;
                @endphp
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: left;">Total:{{ $totalstock }}</td>
                <td>Total:{{ $totalprice }}</td>
                <td></td>
                <td>{{ $fullamount }}</td>
            </tr>
        </table>

        {!! $newproduct->render() !!}


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
                            <a href="{{ route('deletenewproducts', $item->id ?? 0) }}" class="btn btn-danger"><i
                                    class="fa fa-trash-o"></i>
                                Delete </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--------------------------------------------->
        @endforeach



        <!--Date Picker -->

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


    <!-- Date Picker Script End -->
@endsection
