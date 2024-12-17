@extends('layouts.app')
@section('title', 'Edit Job Categories')
@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Edit Service
                            <small>Category</small>
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
                        <li class="breadcrumb-item">Service </li>
                        <li class="breadcrumb-item active">Edit Service</li>
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
                <form class="needs-validation" action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <h4>Edit Service</h4>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="name" class="col-xl-3 col-md-4"><span>*</span>
                                            Name</label>
                                        <div class="col-md-7">
                                            <input class="form-control" id="name" name="name" value="{{$category->name}}" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="spanish_name" class="col-xl-3 col-md-4"><span>*</span>
                                            Spanish Name</label>
                                        <div class="col-md-7">
                                            <input class="form-control" id="spanish_name" name="spanish_name" value="{{$category->spanish_name}}" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="picture" class="col-xl-3 col-md-4"><span>*</span>Icon (Fontawesome Code)</label>
                                        <div class="col-md-7">
                                            <input class="form-control" id="picture" name="picture" value="{{$category->picture}}" type="text" required="">
                                        </div>
                                        <div class="valid-feedback">Please Provide a Valid Fontawesome Icon Code.
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4" for="commission"><span>*</span>Commission</label>
                                        <div class="col-md-7">
                                            <input class="form-control" type="number" id="commission" name="commission" value="{{$category->commission}}" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4"><span>*</span>Status</label>
                                        <div class="col-md-7">
                                            <div class="form-group m-checkbox-inline mb-0 custom-radio-ml d-flex radio-animated">
                                                <label class="d-block" for="enable">
                                                    <input class="radio_animated" id="enable" type="radio" name="status" value="1" <?php if (isset($category->status) && $category->status == 1) echo "checked"; ?>>
                                                    Enable
                                                </label>
                                                <label class="d-block" for="disable">
                                                    <input class="radio_animated" id="disable" type="radio" name="status" value="0" <?php if (isset($category->status) && $category->status == 0) echo "checked"; ?>>
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
                        <a href="{{route('categories.index')}}" class="btn btn-success mt-md-0 mt-2">Back</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
@endsection
