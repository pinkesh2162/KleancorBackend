@extends('layouts.app')@section('title', 'User List')
@section('content')
<div class="page-body">
    <style>
        .pointer-none{
            pointer-events: none !important;
        }
    </style>
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
                    @if($user->is_verified_document == 1)
                        <div class="d-flex justify-content-center">
                            <h3>Now user is fully verified</h3>
                        </div>
                    @endif
                    <div class="my-3 d-flex justify-content-end">
                        <a href="{{ route('users.index') }}" class="btn btn-primary mt-md-0 mt-2">Back</a>
                    </div>
                    <div class="row gap-x-2">
                        <!-- {{$errors}} -->
                        @forelse($user->documents as $key => $document)
                            @if($document->type === \App\Models\Document::INSURANCE)
                            <div class="col-3">
                                <div>
                                    <a class="text-decoration-none" href="{{ $document->document_url }}" target="_blank">
                                        <div class="shadow rounded d-flex h-100 border p-3 justify-content-center flex-column align-items-center gap-2">
                                            <h3 class="text-black-50">Insurance</h3>
                                            <div>
                                                @if(@$document->doc_type === \App\Models\Document::IMAGE)
                                                    <img src="{{$document->document_url}}"
                                                         class="img-thumbnail"
                                                         style="height: 145px; width: 145px;object-fit: cover" alt="insurance">
                                                @else
                                                    <i class="fas fa-file-pdf fa-10x text-danger"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                    <div class="d-flex justify-content-center py-3 gap-2">
                                        <button
                                                type="button"
                                                data-type="{{\App\Models\Document::INSURANCE}}"
                                                data-status="1"
                                                class="btn btn-success mt-md-0 mt-2 
                                                {{$document->status === \App\Models\Document::VERIFIED 
? 'pointer-none' : 'verifyDocument'}}">
                                            {{$document->status === \App\Models\Document::VERIFIED 
? 'Verified' : 'Verify Now'}}
                                        </button>
                                        <button
                                                type="button"
                                                data-status="2"
                                                data-type="{{\App\Models\Document::INSURANCE}}"
                                                class="btn btn-primary mt-md-0 mt-2 
                                                {{$document->status === \App\Models\Document::REJECTED
 ? 'pointer-none' : 'verifyDocument'}}">
                                            {{$document->status === \App\Models\Document::REJECTED ? 'Rejected' : 'Reject'}}
                                            
                                        </button>
                                        
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($document->type === \App\Models\Document::OFFICIAL_ID)
                        <div class="col-3">
                            <div>
                                <a class="text-decoration-none" href="{{ $document->document_url }}" target="_blank">
                                    <div class="shadow rounded h-100 d-flex border p-3 justify-content-center flex-column align-items-center gap-2">
                                        <h3 class="text-black-50">Official Id</h3>
                                        <div>
                                            @if($document->doc_type === \App\Models\Document::IMAGE)
                                                <img src="{{$document->document_url}}" class="img-thumbnail" style="height: 145px; width: 145px;object-fit: cover" alt="doc">
                                            @else
                                                <i class="fas fa-file-pdf fa-10x text-danger"></i>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                <div class="d-flex justify-content-center py-3 gap-2">
                                    <button
                                            type="button"
                                            data-status="1"
                                            data-type="{{\App\Models\Document::OFFICIAL_ID}}"
                                            class="btn btn-success mt-md-0 mt-2
{{$document->status === \App\Models\Document::VERIFIED ? 'pointer-none' : 'verifyDocument'}}">
                                        {{$document->status === \App\Models\Document::VERIFIED ? 'Verified' : 'Verify Now'}}
                                    </button>
                                    <button
                                            type="button"
                                            data-status="2"
                                            data-type="{{\App\Models\Document::OFFICIAL_ID}}"
                                            class="btn btn-primary mt-md-0 mt-2
                                             {{$document->status === \App\Models\Document::REJECTED 
? '' : 'verifyDocument'}}">
                                        {{$document->status === \App\Models\Document::REJECTED ? 'Rejected' : 'Reject'}}
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($document->type === \App\Models\Document::CERTIFICATE)
                        <div class="col-3">
                            <div>
                                <a class="text-decoration-none" href="{{ $document->document_url }}" target="_blank">
                                    <div class="shadow rounded h-100 border p-3 d-flex justify-content-center flex-column align-items-center gap-2">
                                        <h3>Certificate</h3>
                                        @if($document->doc_type === \App\Models\Document::IMAGE)
                                            <img src="{{$document->document_url}}"
                                                 class="img-thumbnail" style="height: 145px; width: 145px;object-fit: cover" alt="doc">
                                        @else
                                            <i class="fas fa-file-pdf fa-10x text-danger"></i>
                                        @endif
                                    </div>
                                </a>
                                <div class="d-flex justify-content-center py-3 gap-2">
                                    <button
                                            type="button"
                                            data-status="1"
                                            data-type="{{\App\Models\Document::CERTIFICATE}}"
                                            class="btn btn-success mt-md-0 mt-2
                                             {{$document->status === \App\Models\Document::VERIFIED 
? 'pointer-none' : 'verifyDocument'}}">
                                        {{$document->status === \App\Models\Document::VERIFIED 
? 'Verified' : 'Verify Now'}}
                                    </button>
                                    <button
                                            type="button"
                                            data-status="2"
                                            data-type="{{\App\Models\Document::CERTIFICATE}}"
                                            class="btn btn-primary mt-md-0 mt-2 
                                            {{$document->status === \App\Models\Document::REJECTED ? '' : 'verifyDocument'}}">
                                        {{$document->status === \App\Models\Document::REJECTED ? 'Rejected' : 'Reject'}}
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($document->type === \App\Models\Document::RESUME)
                        <div class="col-3">
                            <div>
                                <a class="text-decoration-none" href="{{ $document->document_url }}" target="_blank">
                                    <div class="shadow rounded h-100 border p-3 d-flex justify-content-center flex-column align-items-center gap-2">
                                        <h3>Resume</h3>
                                        <div>
                                            @if($document->doc_type === \App\Models\Document::IMAGE)
                                                <img src="{{$document->document_url}}" class="img-thumbnail" style="height: 145px; width: 145px;object-fit: cover" alt="doc">
                                            @else
                                                <i class="fas fa-file-pdf fa-10x text-danger"></i>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                <div class="d-flex justify-content-center py-3 gap-2">
                                    <button
                                            type="button"
                                            data-status="1"
                                            data-type="{{\App\Models\Document::RESUME}}"
                                            class="btn btn-success mt-md-0 mt-2 
                                            {{$document->status === \App\Models\Document::VERIFIED 
? 'pointer-none' : 'verifyDocument'}}">
                                        {{$document->status === \App\Models\Document::VERIFIED 
                                     ? 'Verified' : 'Verify Now'}}
                                    </button>
                                    <button
                                            type="button"
                                            data-status="2"
                                            data-type="{{\App\Models\Document::RESUME}}"
                                            class="btn btn-primary mt-md-0 mt-2
{{$document->status === \App\Models\Document::REJECTED ? '' : 'verifyDocument'}}">
                                      {{$document->status === \App\Models\Document::REJECTED ? 'Rejected' : 'Reject'}}
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                        @empty
                        <h1 class="text-center text-black-50">No documents are currently uploaded.</h1>
                        @endforelse
                    </div>
{{--                    @if(@$user->documents->count() > 0)--}}
{{--                    <div class="my-5 d-flex justify-content-center">--}}
{{--                        @if(@$user->is_verified_document)--}}
{{--                        <button type="submit" class="btn btn-success mt-md-0 mt-2">Verified</button>--}}
{{--                        @else--}}


{{--                        <button--}}
{{--                            type="button"--}}
{{--                            data-bs-toggle="modal" data-bs-target="#verifyDocument"--}}
{{--                            class="btn btn-primary mt-md-0 mt-2">--}}
{{--                            Verify Now--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                    @endif--}}
{{--                    @endif--}}
                </div>
            </div>
        </div>
        <div class="modal fade" id="verifyDocumentModel" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
{{--                    action="{{ route('users.verifying', $user->id) }}"--}}
                    <form id="verifyDocumentForm"  method="POST">
                        @csrf
                        <input id="verifyDocumentType" type="hidden" name="type" value="">
                        <input id="verifyDocumentStatus" type="hidden" name="status" value="">
                        <div class="modal-header">
                            <h5 class="modal-title" id="documentModalLabel">
                                Are you sure you want to verify document?
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
    <script>
        $(document).on('click','.verifyDocument', function () {
            const documentType = $(this).attr('data-type');
            const documentStatus = $(this).attr('data-status');
            const url = window.location.href.split("?")[0];
            const verifyDocumentForm = document.getElementById("verifyDocumentForm");
            let modelTitle = document.getElementById("documentModalLabel");
            if (documentStatus == 2) {
                modelTitle.innerText = modelTitle.innerText.replace('verify', 'reject');
            } else {
                modelTitle.innerText = modelTitle.innerText.replace('reject', 'verify');
            }
            const inputType = document.getElementById("verifyDocumentType");
            const inputStatus = document.getElementById("verifyDocumentStatus");
            inputType.value = documentType;
            inputStatus.value = documentStatus;
            verifyDocumentForm.action = `${url}/verifying`;

            new bootstrap.Modal(
                document.getElementById("verifyDocumentModel")
            ).show();
        });
    </script>
</div>
@endsection
