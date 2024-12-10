@extends('layouts.app')
@section('title', 'HouseKeeping')
@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>HouseKeeping List
                            <small>HouseKeeping</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item">
                            <a href="index.html">
                                <i data-feather="home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">HouseKeeping</li>
                        <li class="breadcrumb-item active">HouseKeeping List</li>
                    </ol>
                </div>
            </div>
        </div>
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-dismiss="alert"></button>
            {{ session('error') }}
        </div>
        @endif
        @if (session('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-dismiss="alert"></button>
            {{ session('message') }}
        </div>
        @endif
    </div>
    <!-- Container-fluid Ends-->

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <form class="form-inline">
                    <div class="form-group">

                    </div>
                </form>

                <a href="{{ route('housekeepings.create') }}" class="btn btn-primary mt-md-0 mt-2">Create HouseKeeping</a>
            </div>
            <div class="card-body vendor-table">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>category Name</th>
                            <th>Minimum</th>
                            <th>Maximum</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($housekeepings as $housekeeping)
                        <tr>
                            <td>{{ $housekeeping->name }}</td>
                            <td>{{ $housekeeping->cname }}</td>
                            <td>{{ $housekeeping->min_val }}</td>
                            <td>{{ $housekeeping->max_val }}</td>
                            @if($housekeeping->status == 1)
                            <td>
                                <div>
                                    <span class="badge badge-success">Active</span>
                                </div>
                            </td>
                            @else
                            <td>
                                <span class="badge badge-primary">Deactive</span>
                            </td>
                            @endif
                            <td>
                                <div>
                                    <form action="{{ route('housekeepings.destroy',$housekeeping->id) }}" method="POST">
                                        <a href="{{ route('housekeepings.edit', $housekeeping->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>

                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
@endsection
