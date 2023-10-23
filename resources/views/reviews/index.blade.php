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
<div class="card m-2" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">rating : {{ $review->rating }}</h5>
			<h4 class="card-title">Comment  :{{ $review->comment }}</h4>
			<h4 class="card-title">Freelancer: {{ $review->freelancer->name }}</h4>
		    <h4 class="card-title">Author: {{ $review->author->name }}</h4>
			
		</div>
    </div>
@endforeach


your reviews :

			<!-- On parcourt la collection de Post -->
			@foreach ($reviews as $review)
            @if (auth()->user()->id === $review->freelancerId)
			<div class="card m-2" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">rating : {{ $review->rating }}</h5>
			
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