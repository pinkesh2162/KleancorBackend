@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-left">
                            <h3>Edit User
                                <small>User</small>
                            </h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ol class="breadcrumb pull-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">
                                    <i data-feather="home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">User </li>
                            <li class="breadcrumb-item active">Edit User</li>
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
            <div class="card tab2-card">
                <div class="card-body">
                    <form class="needs-validation" action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="general" role="tabpanel"
                                aria-labelledby="general-tab">
                                <h4>Edit User</h4>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="first_name" class="col-xl-3 col-md-4"><span>*</span>
                                                First Name</label>
                                            <div class="col-md-7">
                                                <input class="form-control" id="first_name" name="first_name"
                                                    value="{{ $user->first_name }}" type="text" required="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="last_name" class="col-xl-3 col-md-4"><span>*</span>
                                                Last Name</label>
                                            <div class="col-md-7">
                                                <input class="form-control" id="last_name" name="last_name"
                                                    value="{{ $user->last_name }}" type="text" required="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-xl-3 col-md-4"><span>*</span>
                                                Email</label>
                                            <div class="col-md-7">
                                                <input class="form-control" id="email" name="email"
                                                    value="{{ $user->email }}" type="email" required="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-md-4"><span>*</span>Admin Roll</label>
                                            <div class="col-md-7">
                                                <div
                                                    class="form-group m-checkbox-inline mb-0 custom-radio-ml d-flex radio-animated">
                                                    <label class="d-block" for="enable">
                                                        <input class="radio_animated" id="enable" type="radio"
                                                            name="is_admin" value="1" <?php if (isset($user->is_admin) && $user->is_admin == 1) {
                                                                echo 'checked';
                                                            } ?>>
                                                        Enable
                                                    </label>
                                                    <label class="d-block" for="disable">
                                                        <input class="radio_animated" id="disable" type="radio"
                                                            name="is_admin" value="0" <?php if (isset($user->is_admin) && $user->is_admin == 0) {
                                                                echo 'checked';
                                                            } ?>>
                                                        Disable
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-md-4"><span>*</span>Status</label>
                                            <div class="col-md-7">
                                                <div
                                                    class="form-group m-checkbox-inline mb-0 custom-radio-ml d-flex radio-animated">
                                                    <label class="d-block" for="enable">
                                                        <input class="radio_animated" id="enable" type="radio"
                                                            name="status" value="1" <?php if (isset($user->status) && $user->status == 1) {
                                                                echo 'checked';
                                                            } ?>>
                                                        Enable
                                                    </label>
                                                    <label class="d-block" for="disable">
                                                        <input class="radio_animated" id="disable" type="radio"
                                                            name="status" value="0" <?php if (isset($user->status) && $user->status == 0) {
                                                                echo 'checked';
                                                            } ?>>
                                                        Disable
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('users.index') }}" class="btn btn-success mt-md-0 mt-2">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
@endsection