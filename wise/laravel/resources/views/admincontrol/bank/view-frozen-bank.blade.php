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
                <th style="width: 20%">Bank Name</th>
                <th style="width: 20%">Account No</th>
                <th style="width: 13%">Branch</th>
                <th>Balanch</th>
                <th>#Edit</th>
            </tr>
        </thead>
        @foreach ($bank as $item)
        <tbody>
            <tr>
                <td>{{ $i }}</td>
                <td>
                    <a href="">{{ $item->name }}</a>
                </td>
                <td>
                    <a href="">{{ $item->account_no }}</a>
                </td>
                <td>
                    {{ $item->branch }}
                </td>
                <td>
                    <a href="">{{ $item->balanch }}</a>
                </td>
                <td>
                    <!--
                    <a href="{{ route('editbank',$item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                        Edit 
                    </a>-->
                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target=""><i
                        class="fa fa-trash-o"></i>
                         Frozen
                    </button>
                    <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#active-{{ $item->id }}"><i
                        class="fa fa-trash-o"></i>
                         Active
                    </button>
                </td>
            </tr>
            
        </tbody>
        @php
            $i++;
        @endphp
        @endforeach
    </table>
    
    {!! $bank->render() !!}



    
    @foreach ($bank as $item)
<!--------------------------------------------->
            <!-- Modal -->
            <div id="active-{{ $item->id }}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{ $item->name??0 }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>Do you want to Active this?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <a href="{{ route('activeviewbank',$item->id??0) }}" class="btn btn-danger"><i class="fa fa-trash-o"></i>
                                Active 
                            </a>
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
