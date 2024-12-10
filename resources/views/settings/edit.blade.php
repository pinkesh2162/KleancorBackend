@extends('layouts.app')
@section('title', 'Edit Job')
@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Edit Setting
                            <small>Settings</small>
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
                        <li class="breadcrumb-item">Setting </li>
                        <li class="breadcrumb-item active">Edit Settings</li>
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
                <form class="needs-validation" action="{{ route('settings.update', $setting->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <h4>Edit Settings</h4>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="time_zone" class="col-xl-3 col-md-4"><span>*</span>
                                            Time Zone</label>
                                        <div class="col-md-7">
                                            <select class="form-select form-control" required="" value="{{ old('time_zone') }}" name="time_zone">
                                                <option value="0">Choose TimeZone</option>
                                                <option value="US/Samoa">US/Samoa</option>
                                                <option value="US/Eastern" selected="">US/Eastern</option>
                                                <option value="US/Hawaii">US/Hawaii</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="job_limit" class="col-xl-3 col-md-4"><span>*</span>
                                            Job Limit</label>
                                        <div class="col-md-7">
                                            <div class="col-md-7">
                                                <input class="form-control" id="job_limit" name="job_limit" value="{{$setting->job_limit}}" type="number" required="">

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pull-right">
                        <a href="{{route('settings.index')}}" class="btn btn-success mt-md-0 mt-2">Back</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
@endsection
