@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('damage.index') }}" class="btn btn-info">Add Damage</a>
        <a href="{{ route('damage.view') }}" class="btn btn-success">View Damage</a>
        <br /><br />
        <span class="section">{{ $title }}</span>


        @if (session('error'))
            <div class="alert alert-success" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if (session('msg'))
            <div class="alert alert-success" role="alert">
                {{ session('msg') }}
            </div>
        @endif

        @php
            $i = 1;
        @endphp

        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th width="100">Date</th>
                    <th>Product Title</th>
                    <th>Reason</th>
                    <th width="40">Quantity</th>
                    @if (Auth::user()->type == 2)
                        <th width="150">Edit / Delete</th>
                    @endif
                </tr>
            </thead>
            @foreach ($allProduct as $item)
                <tbody>
                    <tr>
                        <td>{{ substr($item->created_at, 0, 10) }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->reason }}</td>
                        <td>{{ $item->original_damage }}</td>
                        <td>
                            @if (Auth::user()->type == 2)
                                <a href="{{ route('damage.edit', $item->random_number) }}" class="btn btn-info btn-xs">
                                    <i class="fa fa-pencil"></i>
                                    Edit
                                </a>
                                <a href="{{ route('damage.delete', $item->random_number) }}" class="btn btn-danger btn-xs"
                                    onclick="return confirm('Are you sure you want to delete this item?');">
                                    <i class="fa fa-trash-o"></i>
                                    Delete
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            @endforeach
        </table>
        {{ $allProduct->links() }}
    </div>
@endsection
