@extends('layouts/contentNavbarLayout')

@section('title', 'Cards basic   - UI elements')

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/masonry/masonry.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">UI Elements /</span> Categories List</h4>

@section('content')
    <div class="container">
        <h1>Skills</h1>
        
        <a href="{{ route('skills.create') }}" class="btn btn-primary">Create New Skill</a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($skills as $skill)
                    <tr>
                        <td>{{ $skill->id }}</td>
                        <td>{{ $skill->skillName }}</td>
                        <td>{{ $skill->description }}</td>
                        <td>{{ $skill->category->name }}</td> 
                        <td>
                            <a href="{{ route('skills.show', $skill) }}" class="btn btn-info">View</a>
                            <a href="{{ route('skills.edit', $skill) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('skills.destroy', $skill) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this skill?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection