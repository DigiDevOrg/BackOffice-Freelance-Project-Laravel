@extends('layouts/contentNavbarLayout')

@section('title', 'Cards basic   - UI elements')

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/masonry/masonry.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">UI Elements /</span> Categories List</h4>

@section('content')
<div class="container">
    <h1>Add New Skill</h1>

    <form action="{{ route('skills.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="skillName">Skill Name</label>
            <input type="text" class="form-control" id="skillName" name="skillName" placeholder="Enter skill name" value="{{ old('skillName') }}">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="{{ old('description') }}">
        </div>
        <div class="form-group">
            <label for="category_id">Category</label>
            <select class="form-control" id="category_id" name="category_id">
                <option value="" disabled selected>Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Skill</button>
    </form>
</div>
@endsection