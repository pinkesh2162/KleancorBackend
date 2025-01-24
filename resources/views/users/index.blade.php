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
                <form class="d-flex align-items-center gap-2">
                    <select
                        class="form-select form-control" id="statusFilter">
                        <option>All</option>
                        <option value="1" {{request()->status == '1' ? 'selected' : ''}}>Active</option>
                        <option value="0" {{request()->status == '0' ? 'selected' : ''}}>Deactivate</option>
                    </select>
                    <button style="min-width: 180px;" id="deleteAllUserBtn" type="button" class="btn d-none btn-primary btn-sm">

                    </button>
                </form>
                <a href="{{ route('users.create') }}" class="btn btn-primary mt-md-0 mt-2">Create User</a>


            </div>
            <div class="card-body">
                <!-- vendor-table -->
                <table class="display" id="basic-1" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>
                                <input style="cursor: pointer;" type="checkbox" id="checkAllUsers">
                            </th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Verification
                                Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>
                                <input
                                    style="cursor: pointer;"
                                    type="checkbox" class="users-row-checkbox" value="{{ $user->id }}">
                            </td>
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
                                <span style="cursor: pointer;" onclick="handleStatusActive({{$user->id}})" class="badge badge-success">Active</span>
                            </td>
                            @else
                            <td>
                                <span style="cursor: pointer;" onclick="handleStatusActive({{$user->id}})" class="badge badge-primary">Deactivate</span>
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
                                <div class="d-flex gap-3 justify-content-center">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <!-- <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE') -->
                                    <button type="button" class="btn btn-primary btn-sm"
                                        onclick="handleConfirmDelete({{ $user->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    <!-- </form> -->
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- delete user model -->
    <div class="modal fade" id="deleteUserModel" tabindex="-1" aria-labelledby="deleteUserModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModel">
                        Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteUserForm" method="POST" style="display:inline;">
                        <!-- <form action="{{ route('users.destroy', $user->id) }}" method="POST"> -->
                        <input type="hidden" id="usersId" name="usersId" value="[]">

                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- status active deactivate model -->
    <div class="modal fade" id="statusUserModel" tabindex="-1" aria-labelledby="statusUserModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="statusUserModel">
                        Change Status
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to change status of this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="changeStatusForm" method="POST" style="display:inline;">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-danger">Change</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->
</div>
<script>
    function handleConfirmDelete(userId) {

        const deleteForm = document.getElementById('deleteUserForm');
        const url = window.location.href.split('?')[0];
        deleteForm.action = `${url}/${userId}`;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteUserModel'));
        deleteModal.show();
    }

    document.getElementById('statusFilter').addEventListener('change', function(event) {
        const url = new URL(window.location.href);
        const params = url.searchParams;
        params.set('status', event.target.value);
        window.location.href = url.toString();
    });

    function handleStatusActive(userId) {
        console.error(userId);
        const statusForm = document.getElementById('changeStatusForm');
        const url = window.location.href.split('?')[0];

        statusForm.action = `${url}/${userId}/change-status`;
        const statusModel = new bootstrap.Modal(document.getElementById('statusUserModel'));
        statusModel.show();

    }
</script>
@endsection