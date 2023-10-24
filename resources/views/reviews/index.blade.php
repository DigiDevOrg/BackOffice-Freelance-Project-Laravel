
@extends("layouts/contentNavbarLayout")
@section("title", "Tous les articles")
@section("content")

	<h1> Reviews</h1>

	<!-- Le tableau pour lister les articles/posts -->
	<table border="1" >
		<thead>
			
		</thead>
		<tbody>
		<h2>Top 5 reviews</h2>
		@foreach ($topRatedReviews as $review)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card m-2" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Rating: {{ $review->rating }}</h5>
                    <h4 class="card-title">Comment: {{ $review->comment }}</h4>
                    <h4 class="card-title">Freelancer: {{ $review->freelancer->name }}</h4>
                    <h4 class="card-title">Author: {{ $review->author->name }}</h4>
                </div>
            </div>
        </div>
    @endforeach


 reviews about:
@php
    $classNames = ['bg-warning', 'bg-danger', 'bg-success', 'bg-info', 'bg-primary', 'bg-secondary'];
    shuffle($classNames);
    $classNamesCount = count($classNames);
    @endphp

			<!-- On parcourt la collection de Post -->
			@foreach ($reviews as $review)
			@php
    $cssClass = $classNames[array_rand($classNames)]; 
    @endphp

            @if (auth()->user()->id === $review->freelancerId)
			    <div class="col-md-6 col-xl-4">
        <div class="card {{ $cssClass }} text-white mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title" style="color : white;">rating : {{ $review->rating }}</h5>
			
			<h4 class="card-title">Comment  :{{ $review->comment }}</h4>
			<h4 class="card-title">Freelancer: {{ $review->freelancer->name }}</h4>
		    <h4 class="card-title">Author: {{ $review->author->name }}</h4>
			
			
		</div>
    </div>
    @endif
			@endforeach
		</tbody>
	</table>
	
@endsection