@extends('layouts.app')
@section('title', 'Create HouseKeeping Radio')
@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Create HouseKeeping Radio
                            <small>HouseKeeping Radio</small>
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
                        <li class="breadcrumb-item">HouseKeeping Radio</li>
                        <li class="breadcrumb-item active">Create Radio</li>
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
                <form class="needs-validation" action="{{ route('housekeepingradios.store') }}" method="POST">
                    @csrf
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <h4>HouseKeeping Radio</h4>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="posting_title" class="col-xl-3 col-md-4"><span>*</span>
                                            Job Posting Title</label>
                                        <div class="col-md-7">
                                            <input class="form-control" id="posting_title" name="posting_title" value="{{old('posting_title')}}" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="display_title" class="col-xl-3 col-md-4"><span>*</span>
                                            Job Display Title</label>
                                        <div class="col-md-7">
                                            <input class="form-control" id="display_title" name="display_title" value="{{old('display_title')}}" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-xl-3 col-md-4"><span>*</span>
                                            Category</label>
                                        <div class="col-md-7">
                                            <select class="form-select form-control" required="required" value="{{ old('category_id') }}" name="category_id">
                                                <option value="">Choose Category</option>
                                                @foreach($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="serial" class="col-xl-3 col-md-4"><span>*</span>
                                            Serial</label>
                                        <div class="col-md-7">
                                            <input class="form-control" id="serial" name="serial" value="{{old('serial')}}" type="number" required="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-md-4"><span>*</span>Status</label>
                                        <div class="col-md-7">
                                            <div class="form-group m-checkbox-inline mb-0 custom-radio-ml d-flex radio-animated">
                                                <label class="d-block" for="enable">
                                                    <input class="radio_animated" id="enable" type="radio" name="status" value="1" checked="">
                                                    Enable
                                                </label>
                                                <label class="d-block" for="disable">
                                                    <input class="radio_animated" id="disable" type="radio" name="status" value="0">
                                                    Disable
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label><span>*</span>Label</label>
                                            <input class="form-control" id="label" name="label[]" value="" type="text" required="">
                                        </div>
                                        <div class="col-md-5">
                                            <label><span>*</span>Order</label>
                                            <input class="form-control" id="label" name="value[]" value="" type="text" required="">
                                        </div>
                                    </div>

                                    <div class="btn btn-success add-more-btn">Add more</div>



                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pull-right">
                        <a href="{{route('housekeepingradios.index')}}" class="btn btn-success mt-md-0 mt-2">Back</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>


<script>
    $(document).ready(function() {
        var htmlCode = `<div class="form-group row">
                            <div class="col-md-5">
                                <label><span>*</span>Label</label>
                                <input class="form-control" id="label" name="label[]" value="" type="text" required="">
                            </div>
                            <div class="col-md-5">
                                <label><span>*</span>Value</label>
                                <input class="form-control" id="label" name="value[]" value="" type="text" required="">
                            </div>
                            <div class="col-md-1 close-label"><i class="fa fa-trash btn btn-primary btn-md"></i></i></div>
                        </div>`;

        $('body').on('click', '.add-more-btn', function() {
            $(this).before(htmlCode);
        });
        $('body').on('click', '.close-label', function() {
            $(this).closest('.form-group').remove();
        });
    });

</script>
@endsection
