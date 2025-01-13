@extends('layouts.app')
@section('title', 'User List')
@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-left">
                            <h3>User List
                                <small>All Users</small>
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
                            <li class="breadcrumb-item">Users</li>
                            <li class="breadcrumb-item active">User List</li>
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

                    <a href="{{ route('users.create') }}" class="btn btn-primary mt-md-0 mt-2">Create User</a>
                </div>
                <div class="card-body vendor-table">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Verification Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        {{ $user->first_name }}
                                        {{ $user->last_name }}
                                    </td>
                                    <td>
                                        <div class="d-flex vendor-list">
                                            {{ $user->email }}
                                        </div>
                                    </td>
                                    <td>{{ $user->is_admin }} </td>

                                    @if ($user->status == 1)
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
                                            <a href="{{route('users.show',['user' => $user->id])}}">
                                            <span class="badge 
{{$user->is_verified_document ? 'badge-success' : 'badge-primary'}}">
                                                {{$user->is_verified_document ? 'Verified' : 'Verify'}}
                                            </span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            {{-- <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form> --}}
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
