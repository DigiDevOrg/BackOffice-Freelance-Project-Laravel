@extends('layouts/contentNavbarLayout')

@section('title', 'Cards basic - UI elements')

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">UI Elements /</span> Categories List</h4>

<div class="row">
    @php
    $classNames = ['bg-warning', 'bg-danger', 'bg-success', 'bg-info', 'bg-primary', 'bg-secondary'];
    shuffle($classNames);
    $classNamesCount = count($classNames);
    @endphp

    @foreach ($categories as $category)
    @php
    $cssClass = $classNames[array_rand($classNames)]; // Pick a random class
    @endphp

    <div class="col-md-6 col-xl-4">
        <div class="card {{ $cssClass }} text-white mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title" style="color : white;">{{ $category->name }}</h5>
                </div>
                <div>
                    <a href="{{ route('categories.edit', $category->id) }}"
                        class="btn btn-{{ $cssClass }} btn-sm" title="Edit Category">
                        <i class="bx bx-edit-alt"></i>
                    </a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                        style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-{{ $cssClass }} btn-sm" title="Delete Category">
                            <i class="bx bxs-message-square-x"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $category->description }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>
<!--/ Horizontal -->
@endsection
