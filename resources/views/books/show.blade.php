@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $book->title }}</h1>
        <p><strong>Autor:</strong> {{ $book->author->name }}</p>
        <p><strong>Editora:</strong> {{ $book->publisher->name }}</p>
        <p><strong>Ano de Publicação:</strong> {{ $book->published_year }}</p>
        <p><strong>Categorias:</strong>
            @foreach ($book->categories as $category)
                <span class="badge bg-secondary">{{ $category->name }}</span>
            @endforeach
        </p>

        @if($book->cover_image)
        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Imagem de Capa" style="max-width: 200px;">
        @else
        <p><em>Nenhuma imagem de capa disponível</em></p>
        @endif


        <a href="{{ route('books.index') }}" class="btn btn-primary">Voltar à Lista</a>
        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning">Editar</a>
        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este livro?')">Excluir</button>
        </form>

        <hr>

        <!-- Comentários -->
        <h3>Comentários:</h3>
        @foreach ($book->comments as $comment)
            <div class="mb-3">
                <strong>Anônimo</strong> disse:
                <p>{{ $comment->comment }}</p>
                <small>Em {{ $comment->created_at->format('d/m/Y H:i') }}</small>
            </div>
        @endforeach

        <!-- Formulário para adicionar um comentário -->
        <form action="{{ route('comments.store', $book->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="comment" class="form-label">Deixe um comentário:</label>
                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

    </div>
@endsection

