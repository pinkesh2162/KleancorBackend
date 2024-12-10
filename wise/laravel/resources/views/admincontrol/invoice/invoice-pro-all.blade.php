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
    <h2>{{ $title }}</h2>
    <table class="table table-striped projects">
      <thead>
        <tr>
          <th style="width: 25%">Particulars</th>
          <th style="width: 15%">Account</th>
          <th style="width: 10%">Amount</th>
          <th style="width: 10%">Invoice Date</th>
          <th style="width: 10%">Due Date</th>
          <th style="width: 5%">Status</th>
          <th>Manage</th>
        </tr>
      </thead>
      @foreach ($allInvoice as $value)
        <tbody>
          <tr>
            <td>
              <a href="{{ route("invoice-pro.printPreview", $value->id) }}">
                {{ $value->subject }} <br />
                {{  $value->id}}/{{ $value->invoice_prefix }}
              </a>
            </td>
            <td> {{ $value->company_name }}<br />
              {{ $value->contact_person }}
            </td>
            <td>TK. {{ $value->amount }}</td>
            <td>{{ $value->created_at }}</td>
            <td>{{ $value->due_date }}</td>
            <td>{!! ($value->status)?'<span class="label label-success">Paid</span>':'<span class="label label-danger">Unpaid</span>' !!}</td>
            <td class="text-right">
              <a href="{{ route("invoice-pro.printPreview", $value->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> View</a>
              <a href="{{ route("invoice-pro.edit", $value->id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit</a>
              @if(Auth::user()->type == 2)
              <a href="{{ route("invoice-pro.delete", $value->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>
                 Delete</a>
              @endif
            </td>
          </tr>

        </tbody>
        @php
        $i++;
        @endphp
      @endforeach
    </table>



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
