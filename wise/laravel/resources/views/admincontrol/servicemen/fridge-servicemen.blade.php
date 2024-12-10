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
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 1%">Sl</th>
                    <th style="width: 20%">Title</th>
                    <th style="width: 10%">Cost</th>
                    <th style="width: 10%">Earning </th>
                    <th style="width: 17%">Customer Name</th>
                    <th style="width: 12%">Date</th>
                    <th>#Edit</th>
                </tr>
            </thead>
            @foreach ($service as $item)
                <tbody>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>
                            <a href="">{{ $item->title }}</a>
                        </td>
                        <td>
                            <a href="">{{ $item->cost }}</a> tk
                        </td>
                        <td>
                            {{ $item->earning }} tk
                        </td>
                        <td>
                            {{ $item->cusname }}
                        </td>
                        <td>
                            {{ $item->date }}
                        </td>
                        <td>
                            @if (Auth::user()->type == 2)
                                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target=""><i
                                        class="fa fa-trash-o"></i> Frozen</button>
                                <button type="button" class="btn btn-info btn-xs" data-toggle="modal"
                                    data-target="#active-{{ $item->id }}"><i class="fa fa-trash-o"></i> Active</button>
                                <!--
                       
                            <a href="{{ route('transaction.edit-expense', $item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                                Edit </a>
                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal-{{ $item->id }}"><i
                                    class="fa fa-trash-o"></i> Delete</button>-->
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

        {!! $service->render() !!}


        @foreach ($service as $item)
            <!--------------------------------------------->
            <!-- Modal -->
            <div id="active-{{ $item->id }}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{ $item->title ?? 0 }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>Do you want to Active this?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <a href="{{ route('activeservicemen', $item->id ?? 0) }}" class="btn btn-danger"><i
                                    class="fa fa-trash-o"></i>
                                Active </a>
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
