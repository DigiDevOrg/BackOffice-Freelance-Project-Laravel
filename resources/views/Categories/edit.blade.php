@extends('layouts/contentNavbarLayout')

@section('title', 'Cards basic - UI elements')

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <h1>Edit Category</h1>

    <form method="POST" action="{{ route('categories.update', $category->id) }}">
        @csrf
        @method('PUT') {{-- Use the PUT method for updating data --}}

        <div class="form-group">
            <label for "name">Category Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $category->description }}</textarea>
        </div>
    </form>
    <br/>

    <div class="text-light small fw-semibold mb-3"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTop">
    <i class='bx bxs-plus-square'></i>
    Add Skill
          </button></div>
    
    
    <div class="toast-container d-flex flex-wrap">
        @php
        $toastColors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info'];
        shuffle($toastColors);
        $classNamesCount = count($toastColors);
        @endphp
        @foreach ($skills as $skill)
        @php
        $color = $toastColors[array_rand($toastColors)]; // Pick a random class
        @endphp
        <div class="bs-toast toast fade show bg-{{ $color }}" role="alert" aria-live="assertive" aria-atomic="true"
            style="margin-right: 10px; margin-bottom: 10px;"> <!-- Adjust margin as needed -->
            <div class="toast-header">
                <div class="me-auto fw-semibold">{{ $skill->skillName }}</div>
                <small>11 mins ago</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
            {{ $skill->description }}
            </div>
        </div>
        @endforeach
    </div>

    <button type="submit" class="btn btn-primary">Update Category</button>
</div>

<div class="col-lg-4 col-md-6">
        


          <!-- Modal -->
          <div class="modal modal-top fade" id="modalTop" tabindex="-1">
            <div class="modal-dialog">
              <form class="modal-content" action="{{ route('skills.store') }}" method="POST">
              @csrf
                <div class="modal-header">
                  <h5 class="modal-title" id="modalTopTitle">Modal title</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col mb-3">
                      <input type="text" class="form-control" id="skillName" name="skillName" placeholder="Enter skill name" value="{{ old('skillName') }}">
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col mb-0">
                      <label for="emailSlideTop" class="form-label">Description</label>
                      <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="{{ old('description') }}">
                    </div>
                    <div class="col mb-0">
                      <label for="category_id" class="form-label">Category</label>
                      <input type="text" id="category_id" name="category_id" class="form-control" placeholder= "{{ $category->name }}" value="{{ $category->id }}">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
@endsection
