@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('stockout') }}" class="btn btn-info">Add Stock Out</a>
        <a href="{{ route('stockout.view') }}" class="btn btn-success">View Stock Out</a>
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
                    <td width="200">
                        <label for="">Products</label>
                        <select class="form-control" name="pdtid">
                            <option value="0">All Product</option>
                            @foreach ($allPdt as $value)
                                <option value="{{ $value->id }}">{{ $value->title }}</option>
                            @endforeach
                        </select>
                    </td>
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
                </tr>
            </table>
        </form>
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 1%">Sl</th>
                    <th>Product Name</th>
                    <th>Stock Out</th>
                    <th>Challan No.</th>
                    <th>Description</th>
                    <th>Date</th>
                    @if (Auth::user()->type == 2)
                        <th>Edit / Delete</th>
                    @endif
                </tr>
            </thead>
            @php
                $installCheque = 0;
                $installCash = 0;
                $total = 0;
            @endphp
            @foreach ($stockout as $item)
                <tbody>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->stock }}</td>
                        <td>{{ $item->challan }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            @if (Auth::user()->type == 2)
                                <a href="{{ route('stockout.edit', $item->id) }}" class="btn btn-info btn-xs">
                                    <i class="fa fa-pencil"></i>
                                    Edit
                                </a>
                                <a href="{{ route('stockout.delete', $item->id) }}" class="btn btn-danger btn-xs">
                                    <i class="fa fa-trash-o"></i>
                                    Delete
                                </a>
                            @endif
                        </td>

                    </tr>
                </tbody>
                @php
                    $i++;
                @endphp
            @endforeach

        </table>




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
