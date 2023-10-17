@extends('layouts/contentNavbarLayout')

@section('title', 'Cards basic   - UI elements')

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/masonry/masonry.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">UI Elements /</span> Categories List</h4>

<div class="row">
  @php
  $classNames = ['bg-warning', 'bg-danger', 'bg-success', 'bg-info', 'bg-primary', 'bg-secondary'];
  shuffle($classNames); 
  $classNamesCount = count($classNames);
  @endphp

  @foreach ($categories as $index => $category)
    @php
    $cssClass = $classNames[$index % $classNamesCount];
    @endphp

    <div class="col-md-6 col-xl-4">
      <div class="card {{ $cssClass }} text-white mb-3">
        <div class="card-body">
          <h5 class="card-title text-white">{{ $category->name}}</h5>
          <p class="card-text">
            {{ $category->description }}
          </p>
        </div>
      </div>
    </div>
  @endforeach
</div>

<!--/ Horizontal -->
@endsection
