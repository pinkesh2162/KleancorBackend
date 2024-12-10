@extends('layouts.app')

@section('content')

  <div class="container">
    <a href="{{ route('product') }}" class="btn btn-info">New Products</a>
    <a href="{{ route('product.view') }}" class="btn btn-success">Acitve Products</a>

    <br /><br />
    <span class="section">{{ $title }}</span>

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
          <th style="width: 15%">Title</th>
          <th>Purchase</th>
          <th>Sold</th>
          <th>Stock</th>
          <th style="width: 30%">Description</th>
          <th>Unit Name</th>
          <th>User Name</th>
          @if(Auth::user()->type == 2)
            <th>Edit / Delete</th>
          @endif
        </tr>
      </thead>
      @foreach ($product as $item)
        <tbody>
          <tr {!! ($item->totalStock <= $item->totalSales)?"class='danger'":'' !!} >
            <td>{{ $i }}</td>
            <td>
              {{ $item->title }}
            </td>
            <td>
              {{ $item->totalStock??0 }}
            </td>
            <td>
              {{ $item->totalSales??0 }}
            </td>
            <td>
              {{ ($item->totalStock - $item->totalSales) }}
            </td>
            <td>
              {{ $item->description }}
            </td>
            <td>{{ $item->unitname }}</td>
            <td>{{ $item->name }}</td>


            <td>
              @if(Auth::user()->type == 2)
                <a href="{{ route('product.edit',$item->id) }}" class="btn btn-success btn-xs">
                  <i class="fa fa-pencil"></i>
                  Edit
                </a>
                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal-{{ $item->id }}">
                  <i class="fa fa-trash-o"></i>
                  Delete
                </button>
              @endif
            </td>
          </tr>
        </tbody>
        @php
        $i++;
        @endphp
      @endforeach
    </table>

    {!! $product->render() !!}


    @foreach ($product as $item)
      <!--------------------------------------------->
      <!-- Modal -->
      <div id="myModal-{{ $item->id }}" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">{{ $item->title??0 }}</h4>
            </div>
            <div class="modal-body">
              <p>Do you want to delete this?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
              <a href="{{ route('product.delete',$item->id??0) }}" class="btn btn-danger"><i class="fa fa-trash-o"></i>
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
