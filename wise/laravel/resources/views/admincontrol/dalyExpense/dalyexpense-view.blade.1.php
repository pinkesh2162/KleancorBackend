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
    $i=1;
    @endphp
    <table class="table table-striped projects">
        <thead>
            <tr>
                <th style="width: 1%">Sl</th>
                <th style="width: 17%">Project Name</th>
                <th style="width: 15%">Title</th>
                <th style="width: 17%">Description</th>
                <th style="width: 10%">Amount</th>
                <th style="width: 10%">Payment Method</th>
                <th style="width: 10%">Status</th>
                <th style="width: 14%">User Name</th>
                <th style="width: 5%">Verified</th>
                <th>#Edit</th>
            </tr>
        </thead>
        @foreach ($dalyExpense as $item)
        <tbody>
            <tr>
                <td>{{ $i }}</td>
                <td>
                    <a href="">{{ $item->projectid }}</a>
                </td>
                <td>
                    <a href="">{{ $item->title }}</a>
                </td>
                <td>
                    {{ $item->description }}
                </td>
                <td>
                    {{ $item->amount }} tk
                </td>
                <td>
                    <a href=""></a>
                </td>

                <td>
                    <a href="">{{ $item->uname }}</a>
                </td>
                <td>{{ $item->verified == 1 ?'Varified':'None Varified' }}</td>
                <td>
                    @if(Auth::user()->type == 2)
                    <a href="{{ route('transaction.edit-expense',$item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                        Edit </a>
                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal-{{ $item->id }}"><i class="fa fa-trash-o"></i> Delete</button>
                    @elseif(Auth::user()->type == 1 && $item->verified == 0)
                    <a href="{{ route('transaction.edit-expense',$item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                        Edit </a>
                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal-{{ $item->id }}"><i class="fa fa-trash-o"></i> Delete</button>
                    @else
                    <a href="#" class="btn btn-primary btn-xs">Already Verified </a>
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
                    <h4 class="modal-title">{{ $item->projectid??0 }}</h4>
                </div>
                <div class="modal-body">
                    <p>Do you want to delete this?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <a href="{{ route('deleteexpense',$item->id??0) }}" class="btn btn-danger"><i class="fa fa-trash-o"></i>
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
@endsection