@extends("layouts/contentNavbarLayout")
@section("title", "Tous les articles")
@section("content")

	<h1>Tous les articles</h1>

	<p>
		<!-- Lien pour créer un nouvel article : "posts.create" -->
		<a href="{{ route('posts.create') }}" title="Créer un article" >Créer un nouveau post</a>
	</p>


			<!-- On parcourt la collection de Post -->
			<div class="d-flex flex-wrap">
    @foreach ($posts as $post)
    <div class="card m-2" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
			<img src="{{ asset('storage/' . $post->picture) }}" class="card-img-top" alt="Post Image">
            <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Lire l'article</a>
            @auth
                @if (auth()->user()->id === $post->user_id)
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-secondary">Modifier</a>
                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
    @endforeach
</div>

	
@endsection