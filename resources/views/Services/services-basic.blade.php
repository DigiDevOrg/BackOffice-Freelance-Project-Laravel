@extends('layouts/contentNavbarLayout')

@section('title', 'Services - All Services')

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Services</h4>

<!-- Examples -->
<div class="row mb-5">
  @foreach($services as $service)
  <div class="col-md-6 col-lg-4 mb-3">
    <div class="card h-100">
      <!-- Replace 'img/src' and 'card-title' and 'card-text' with actual fields from your Service model -->
      <img class="card-img-top" src="{{ asset('storage/assets/img/service/' . $service->image) }}"alt="Card image cap" />
      <div class="card-body">
        <h5 class="card-title">{{ $service->title }}</h5>
        <p class="card-text">{{ $service->description }}</p>
        <p class="card-text">{{ $service->price }}</p>
        <p class="card-text">{{ $service->average_rating }}</p>
        <p class="card-text">{{ $service->user_name}}</p>
        <a href="javascript:void(0)" class="btn btn-outline-primary">Learn More</a>
      </div>
    </div>
  </div>
  @endforeach
</div>
<!-- Examples -->

<!-- Other content types can be added here -->

@endsection
