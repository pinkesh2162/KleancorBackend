@extends('layouts.app')

@section('content')
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

        @php
            $i = 1;
        @endphp

        <form action="" method="GET">
            <input type="text" name="sdate" id="datepicker" autocomplete="off">
            <input type="text" name="edate" id="datepicker2" autocomplete="off">
            <input type="submit" name="submit" value="Search">
        </form>
        <br>

        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 1%">Sl</th>
                    <th>Title</th>
                    <th>Amount</th>
                    <!--
                        <th >Description</th>
                        <th >Cash</th>
                        <th >Bank Name</th>
                        <th >Cheque Amount</th>-->
                    <th>Date</th>
                    <th>#Edit/Delete</th>
                </tr>
            </thead>
            @foreach ($dalyExpense as $item)
                <tbody>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>
                            {{ $item->title }}
                        </td>
                        <td>
                            {{ $item->amount }} tk
                        </td>
                        <td>{{ $item->date }}</td>
                        <td>
                            @if (Auth::user()->type == 2)
                                <a href="{{ route('editexpenses', $item->id) }}" class="btn btn-info btn-xs"><i
                                        class="fa fa-pencil"></i>
                                    Edit </a>
                                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                    data-target="#myModal-{{ $item->id }}"><i class="fa fa-trash-o"></i>
                                    Delete
                                </button>

                                <!--
                                            <button type="button" class="btn btn-dark btn-xs" data-toggle="modal" data-target=""><i
                                                class="fa fa-trash-o"></i>
                                                Verified
                                            </button>
                                        
                                            <a href="{{ route('transaction.edit-expense', $item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                                                Edit </a>
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal-{{ $item->id }}"><i
                                                class="fa fa-trash-o"></i>
                                                Delete
                                            </button>
                                        -->
                            @else
                            @endif
                        </td>
                    </tr>

                </tbody>
                @php
                    $i++;
                @endphp
            @endforeach
        </table>

        {!! $dalyExpense->render() !!}


        @foreach ($dalyExpense as $item)
            <!--------------------------------------------->
            <!-- Modal -->
            <div id="myModal-{{ $item->id }}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">
                                {{ $item->title }}
                            </h4>
                        </div>
                        <div class="modal-body">
                            <p>Do you want to delete this?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <a href="{{ route('deleteexpenses', $item->id ?? 0) }}" class="btn btn-danger"><i
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
    <!-- Date Picker Script End -->
@endsection
