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
        <th>Address</th>
        <th >Email</th>
        <th>Contact Number</th>
        <th>Contact Person</th>
        <th>Designation</th>
        <th>Edit/Delete</th>
      </tr>
    </thead>
    @foreach ($company as $item)
    <tbody>
      <tr>
        <td>{{ $i }}</td>
        <td>
        @if($item->totalStock > 0)
            <a href="{{ route('allcustomers.details', $item->id) }}" class="btn btn-link">
            {{ $item->company_name }}
          </a>
        @else
            {{ $item->company_name }}
        @endif
          
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
        <td>
          {{ $item->designation }}
        </td>
        <td>
          @if(Auth::user()->type == 2)
          @if($item->verified == 1)
          <a href="#" class="btn btn-primary btn-xs">Verified </a>
          @endif
          <a href="{{ route('editcustomers',$item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
            Edit </a>
          <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#fridge-{{ $item->id }}"><i
              class="fa fa-trash-o"></i> Frdige</button>

          @elseif(Auth::user()->type == 1 && $item->verified == 0)
          <a href="{{ route('editcustomers',$item->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
            Edit </a>
          <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal-{{ $item->id }}"><i
              class="fa fa-trash-o"></i> Delete</button>
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

  {!! $company->render() !!}


  @foreach ($company as $item)
  <!--------------------------------------------->
  <!-- Modal -->
  <div id="fridge-{{ $item->id }}" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ $item->company_name??0 }}</h4>
        </div>
        <div class="modal-body">
          <p>Do you want to Fridge this?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
          <a href="{{ route('frozencustomers',$item->id??0) }}" class="btn btn-danger"><i class="fa fa-trash-o"></i>
            Fridge </a>
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
