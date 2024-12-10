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
                <th style="width: 17%">Project Name</th>
                <th style="width: 17%">Customer Name</th>
                <th style="width: 13%">Date</th>
                <th style="width: 10%">Status</th>
                <th style="width: 13%">Verification Status</th>
                <th style="width: ">#Edit</th>
            </tr>
        </thead>
        @foreach ($prjct as $item)
        <tbody>
            <tr>
                <td>{{ $i }}</td>
                <td>
                    <a href="">{{ $item->project_name }}</a>
                </td>
                <td>
                    <a href="">{{ $item->contact_person }}</a>
                </td>
                <td>
                    <a href="">{{ $item->date }}</a>
                </td>
                <td>
                    {{ $item->status == 1?'Active':'Deactive' }}
                </td>
                <td>
                    <a href="">{{ $item->verified == 1 ?'Varified':'Non Varified' }}</a>
                </td>
                <td>
                    @if(Auth::user()->type == 2)
                            
                                <a href="{{ route('editprojects',$item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                                    Edit </a>
                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#fridge-{{ $item->id }}"><i
                                        class="fa fa-trash-o"></i> Fridge</button>
             
                    @endif
                </td>
            </tr>
            
        </tbody>
        @php
            $i++;
        @endphp
        @endforeach
    </table>
    
    {!! $prjct->render() !!}


<!---------- Fridge --------->
    @foreach ($prjct as $item)
<!--------------------------------------------->
            <!-- Modal -->
            <div id="fridge-{{ $item->id }}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{ $item->project_name??0 }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>Do you want to Fridge this?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <a href="{{ route('fridgeprojects',$item->id) }}" class="btn btn-danger"><i class="fa fa-trash-o"></i>
                                Fridge </a>
                            </div>
                    </div>
                </div>
            </div>
<!--------------------------------------------->
@endforeach

<!---------- Delete --------->
    @foreach ($prjct as $item)
<!--------------------------------------------->
            <!-- Modal -->
            <div id="myModal-{{ $item->id }}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{ $item->project_name??0 }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>Do you want to delete this?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <a href="{{ route('deleteprojects',$item->id) }}" class="btn btn-danger"><i class="fa fa-trash-o"></i>
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
