@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-striped projects">
        <thead>
            <tr>
                <th style="width: 1%">Sl</th>
                <th style="width: 20%">Name</th>
                <th style="width: 20%">Email</th>
                <th style="width: 13%">Contact</th>
                <th>Type</th>
                <th>#Edit</th>
            </tr>
        </thead>
        @foreach ($user as $item)
        <tbody>
            <tr>
                <td>#</td>
                <td>
                    <a href="">{{ $item->name }}</a>
                </td>
                <td>
                    <a href="abc@gmail.com">{{ $item->email }}</a>
                </td>
                <td>
                    {{ $item->contract }}
                </td>
                <td>
                    <a href="">{{ $item->type == 1?'Admin':'Operator' }}</a>
                </td>
                <td>  <!--
                    <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i>
                        View </a>-->
                    <a href="{{ route('edituser',$item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                        Edit </a>
                    <a href="{{ route('deleteusers',$item->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i>
                        Delete </a>
                </td>
            </tr>
        </tbody>
        @endforeach
    </table>     
    {!! $user->render() !!}
   <!-----------------------------------------> 
  <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                   <div class="container">
                     <div class="row">
                       <div class="col-sm-12">
                         
                        <div class="col-sm-6">
      <!-----------------------------------------> 
      
      <!----------------------------------------->                    
                        
                        </div>
                  </div>
                      
                     </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
