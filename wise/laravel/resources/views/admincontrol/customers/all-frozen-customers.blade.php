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

    @php
    $i=1;
    @endphp
    <table class="table table-striped projects">
        <thead>
            <tr>
                <th style="width: 1%">Sl</th>
                <th>Company Name</th>
                <th >Address</th>
                <th >Email</th>
                <th>Contact Number</th>
                <th>Conatct Person</th>
                <th>Purchase</th>
                <th>Sells</th>
                <th>Edit / Delete</th>
            </tr>
        </thead>
        @foreach ($company as $item)
        <tbody>
            <tr>
                <td>{{ $i }}</td>
                <td>
                   {{ $item->company_name }}
                </td>
                <td>
                    {{ $item->address }}
                </td>
                <td>
                    {{ $item->email }}
                </td>
                <td>
                    {{ $item->contact_number }}
                </td>
                <td>{{ $item->contact_person }}</td>
               
                <td> <a href="{{ route('viewdetailthiscustomers', $item->id) }}" class="btn btn-primary btn-xs">
                        @if ( $item->totalStock  != "")
                        {{ $item->totalStock }}
                            @else 
                                0
                        @endif          
                                
                    </a>
                </td>
                <td> <a href="{{ route('viewdetailthiscustomers', $item->id) }}" class="btn btn-primary btn-xs">20</a></td>
            
                

                <td>
                    @if(Auth::user()->type == 2)
                    <a class="btn btn-dark btn-xs"><i class="fa fa-pencil"></i>
                        Frozen </a>
                    <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#active-{{ $item->id }}"><i
                            class="fa fa-trash-o"></i> Active</button>

                    @elseif(Auth::user()->type == 1 && $item->verified == 0)
                    <a href="{{ route('editcustomers',$item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                        Edit </a>
                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal-{{ $item->id }}"><i
                            class="fa fa-trash-o"></i> Delete</button>
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

    {!! $company->render() !!}


    @foreach ($company as $item)
    <!--------------------------------------------->
    <!-- Modal -->
    <div id="active-{{ $item->id }}" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ $item->company_name??0 }}</h4>
                </div>
                <div class="modal-body">
                    <p>Do you want to Active this?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <a href="{{ route('activecustomers',$item->id??0) }}" class="btn btn-danger"><i class="fa fa-trash-o"></i>
                        Active </a>
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
                    <h4 class="modal-title">{{ $item->company_name??0 }}</h4>
                </div>
                <div class="modal-body">
                    <p>Do you want to delete this?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <a href="{{ route('deletecustomers',$item->id??0) }}" class="btn btn-danger"><i class="fa fa-trash-o"></i>
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
