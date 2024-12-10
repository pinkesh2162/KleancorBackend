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
                <th style="width: 20%">Employee Name</th>
                <th style="width: 17%">Designation</th>
                <th style="width: 13%">Salary</th>
                <th>User Name</th>
                <th>CV</th>
                <th style="width: 13%">Joining Date</th>
                <th>#Edit</th>
            </tr>
        </thead>
        @foreach ($emplo as $item)
        <tbody>
            <tr>
                <td>{{ $i }}</td>
                <td><a href="">{{ $item->name }}</a></td>
                <td>{{ $item->designation }}</td>
                <td>
                    {{ $item->salary }} tk
                </td>
                <td>{{ $item->uname  }}</td>
                <td>
                  @if($item->extension)
                  <a href="{{route("downloademployee", $item->id)}}" target="_blank"><i class="fa fa-download fa-2x"></i></a>
                  @else
                  ---
                  @endif
                </td>
                <td>
                    {{ $item->created_at }}
                </td>                
                <td>
                    @if(Auth::user()->type == 2)
                         @if($item->verified == 1)
                        <a href="#" class="btn btn-success btn-xs">Verified </a>        
                        @endif
                        @if ($item->status == 1)
                        <a href="{{ route('editemployee',$item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                        Edit </a>
                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#frozen-{{ $item->id }}"><i
                                    class="fa fa-trash-o"></i>
                            Fridge
                        </button>
                        @endif
                       
                    @elseif(Auth::user()->type == 1 && $item->verified == 0)
                        <a href="{{ route('editemployee',$item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                            Edit </a>
                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#frozen-{{ $item->id }}"><i
                                class="fa fa-trash-o"></i> Fridge</button>
                    @else
                    <a href="#" class="btn btn-primary btn-xs">Verified </a>        
                    @endif        
                </td>
            </tr>
            
        </tbody>
        @php
            $i++;
        @endphp
        @endforeach
    </table>
    
    {!! $emplo->render() !!}



   <!----- For unFrozen--------->
   @foreach ($emplo as $item)
   <!--------------------------------------------->
               <!-- Modal -->
               <div id="unfrozen-{{ $item->id }}" class="modal fade" role="dialog">
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
                               <a href="{{ route('unfrozenEmployee',$item->id??0) }}" class="btn btn-danger"><i class="fa fa-trash-o"></i>
                                  Active </a>
                               </div>
                       </div>
                   </div>
               </div>
   <!--------------------------------------------->
   @endforeach
   

    <!----- For Frozen--------->
    @foreach ($emplo as $item)
<!--------------------------------------------->
            <!-- Modal -->
            <div id="frozen-{{ $item->id }}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{ $item->name??0 }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>Do you want to Frozen this?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <a href="{{ route('frozenEmployee',$item->id??0) }}" class="btn btn-danger"><i class="fa fa-trash-o"></i>
                               Fridge </a>
                            </div>
                    </div>
                </div>
            </div>
<!--------------------------------------------->
@endforeach


 <!-------For Delete ------>
@foreach ($emplo as $item)
<!--------------------------------------------->
            <!-- Modal -->
            <div id="myModal-{{ $item->id }}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{ $item->name??0 }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>Do you want to delete this?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <a href="{{ route('deleteemployee',$item->id??0) }}" class="btn btn-danger"><i class="fa fa-trash-o"></i>
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
