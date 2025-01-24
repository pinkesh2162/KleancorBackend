@extends('layouts.app')@section('title', 'User List')
@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Show User
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
                        <li class="breadcrumb-item">User</li>
                        <li class="breadcrumb-item active">Show User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card tab2-card">
            <div class="card-body">
                <div class="container">
                    <div class="my-3 d-flex justify-content-end">
                        <a href="{{ route('users.index') }}" class="btn btn-primary mt-md-0 mt-2">Back</a>
                    </div>
                    <div class="row gap-x-2">
                        <!-- {{$errors}} -->
                        @if($user->insurance_img)
                        <div class="col-3">
                            <a class="text-decoration-none" href="{{ $user->insurance_img }}" target="_blank">
                                <div class="shadow rounded d-flex h-100 border p-3 justify-content-center flex-column align-items-center gap-2">
                                    <h3 class="text-black-50">Insurance</h3>
                                    <div>
                                        @if(@$user->insurance_img_type === \App\Models\Document::IMAGE)
                                        <img src="{{$user->insurance_img}}" class="img-thumbnail" style="height: 100px; width: 100px;object-fit: cover" alt="insurance">
                                        @else
                                        <i class="fas fa-file-pdf fa-6x text-danger"></i>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif
                        @forelse($user->documents as $key => $document)
                        @if($document->type === \App\Models\Document::OFFICIAL_ID)
                        <div class="col-3">
                            <a class="text-decoration-none" href="{{ $document->document_url }}" target="_blank">
                                <div class="shadow rounded h-100 d-flex border p-3 justify-content-center flex-column align-items-center gap-2">
                                    <h3 class="text-black-50">Official Id</h3>
                                    <div>
                                        @if($document->doc_type === \App\Models\Document::IMAGE)
                                        <img src="{{$document->document_url}}" class="img-thumbnail" style="height: 100px; width: 100px;object-fit: cover" alt="doc">
                                        @else
                                        <i class="fas fa-file-pdf fa-6x text-danger"></i>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif
                        @if($document->type === \App\Models\Document::CERTIFICATE)
                        <div class="col-3">
                            <a class="text-decoration-none" href="{{ $document->document_url }}" target="_blank">
                                <div class="shadow rounded h-100 border p-3 d-flex justify-content-center flex-column align-items-center gap-2">
                                    <h3>Certificate</h3>
                                    @if($document->doc_type === \App\Models\Document::IMAGE)
                                    <img src="{{$document->document_url}}" class="img-thumbnail" style="height: 100px; width: 100px;object-fit: cover" alt="doc">
                                    @else
                                    <i class="fas fa-file-pdf fa-6x text-danger"></i>
                                    @endif
                                </div>
                            </a>
                        </div>
                        @endif
                        @if($document->type === \App\Models\Document::RESUME)
                        <div class="col-3">
                            <a class="text-decoration-none" href="{{ $document->document_url }}" target="_blank">
                                <div class="shadow rounded h-100 border p-3 d-flex justify-content-center flex-column align-items-center gap-2">
                                    <h3>Resume</h3>
                                    <div>
                                        @if($document->doc_type === \App\Models\Document::IMAGE)
                                        <img src="{{$document->document_url}}" class="img-thumbnail" style="height: 100px; width: 100px;object-fit: cover" alt="doc">
                                        @else
                                        <i class="fas fa-file-pdf fa-6x text-danger"></i>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif
                        @empty
                        <h1 class="text-center text-black-50">No documents are currently uploaded.</h1>
                        @endforelse
                    </div>
                    @if(@$user->documents->count() > 0)
                    <div class="my-5 d-flex justify-content-center">
                        @if(@$user->is_verified_document)
                        <button type="submit" class="btn btn-success mt-md-0 mt-2">Verified</button>
                        @else


                        <button
                            type="button"
                            data-bs-toggle="modal" data-bs-target="#verifyDocument"
                            class="btn btn-primary mt-md-0 mt-2">
                            Verify Now
                        </button>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="modal fade" id="verifyDocument" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('users.verifying', $user->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="documentModalLabel">
                                Are you sure you want to verify documents?
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-primary">No</button>
                            <button type="submit" class="btn btn-secondary">Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
@endsection