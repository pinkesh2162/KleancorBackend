@extends('layouts.app')

@section('content')

<!-- Page Body Start-->
<div class="page-body">
    <!-- breadcrumb starts-->
    @include('components.breadcrumb')
    <!-- breadcrumb end-->

    <!-- Container-fluid starts-->
    @include('components.graph')
    <!-- Container-fluid end-->
</div>
@endsection
