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
            $totalamount = 0;
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
                    <th style="width: 18%">Bank Name</th>
                    <th style="width: 11%">Amount</th>
                    <th style="width: 10%">Date</th>
                    <th>User Name</th>
                    <th>Verification Status</th>
                    <th>#Edit</th>
                </tr>
            </thead>
            @foreach ($bankdeposit as $item)
                <tbody>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>
                            {{ $item->bankname }}
                        </td>
                        <td>
                            {{ $item->amount }} Tk
                        </td>
                        <td>
                            {{ $item->date }}
                        </td>
                        <td>{{ $item->uname }}</td>
                        <td>{{ $item->verified > 0 ? 'Verified' : 'Non-verified' }}</td>
                        <td>
                            @if (Auth::user()->type == 2)
                                @if ($item->status == 1)
                                    <a href="{{ route('editbankdeposit', $item->id) }}" class="btn btn-info btn-xs"><i
                                            class="fa fa-pencil"></i>
                                        Edit </a>
                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                        data-target="#frozen-{{ $item->id }}"><i class="fa fa-trash-o"></i>
                                        Fridge
                                    </button>
                                @else
                                    <a class="btn btn-danger btn-xs"><i class="fa fa-pencil"></i>
                                        Frozen </a>

                                    <button type="button" class="btn btn-info btn-xs" data-toggle="modal"
                                        data-target="#unfrozen-{{ $item->id }}"><i class="fa fa-trash-o"></i>
                                        Active
                                    </button>
                                @endif
                            @elseif(Auth::user()->type == 1 && $item->verified == 0)
                            @else
                                <a href="#" class="btn btn-primary btn-xs">Already Verified </a>
                            @endif
                        </td>
                    </tr>

                </tbody>
                @php
                    $i++;
                    $totalamount += $item->amount;
                @endphp
            @endforeach
            <tr>
                <thead>
                    <th style="border:none;"></th>
                    <th style="border:none;float:right;margin-right:10px;">Total </th>
                    <th style="border:none;">{{ $totalamount }} Tk</th>
                </thead>
            </tr>
        </table>




        <!----- For unFrozen--------->
        @foreach ($bankdeposit as $item)
            <!--------------------------------------------->
            <!-- Modal -->
            <div id="unfrozen-{{ $item->id }}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{ $item->bankname ?? 0 }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>Do you want to Unfrozen this?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <a href="{{ route('unfrozenbankdeposit', $item->id ?? 0) }}" class="btn btn-danger"><i
                                    class="fa fa-trash-o"></i>
                                Unfridge </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--------------------------------------------->
        @endforeach


        <!----- For Frozen--------->
        @foreach ($bankdeposit as $item)
            <!--------------------------------------------->
            <!-- Modal -->
            <div id="frozen-{{ $item->id }}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{ $item->bankname ?? 0 }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>Do you want to Frozen this?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <a href="{{ route('frozenbankdeposit', $item->id ?? 0) }}" class="btn btn-danger"><i
                                    class="fa fa-trash-o"></i>
                                Fridge </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--------------------------------------------->
        @endforeach


        <!-------For Delete ------>
        @foreach ($bankdeposit as $item)
            <!--------------------------------------------->
            <!-- Modal -->
            <div id="myModal-{{ $item->id }}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{ $item->bankname ?? 0 }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>Do you want to delete this?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <a href="{{ route('deletebankdeposit', $item->id ?? 0) }}" class="btn btn-danger"><i
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
