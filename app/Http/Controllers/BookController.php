<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Função para exibir uma lista de livros
    public function index()
    {
        $books = Book::with(['author', 'publisher', 'categories'])->get();
        return view('books.index', compact('books'));
    }

    // Função para exibir um livro específico
    public function show($id)
    {
        $book = Book::with(['author', 'publisher', 'categories'])->findOrFail($id);
        $book = Book::with('comments')->findOrFail($id);
        return view('books.show', compact('book'));
    }

    // Função para exibir o formulário de criação de um novo livro
        public function create()
    {
        //$this->authorize('create', Book::class);  // Verifica se o usuário pode criar livros
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('books.create', compact('authors', 'publishers', 'categories'));
    }


    // Função para armazenar um novo livro no banco de dados
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|integer',
            'publisher_id' => 'required|integer',
            'published_year' => 'required|integer',
            'categories' => 'required|array',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validação da imagem
        ]);

        // Verificar se há upload de imagem
        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('images', 'public'); // Salva no storage/public/images
            $validatedData['cover_image'] = $imagePath; // Adiciona o caminho ao array de dados validados
        }

        $book = Book::create($validatedData);
        $book->categories()->attach($request->categories);

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso!');
    }

    // Função para exibir o formulário de edição de um livro
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'authors', 'publishers', 'categories'));
    }

    // Função para atualizar um livro no banco de dados
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|integer',
            'publisher_id' => 'required|integer',
            'published_year' => 'required|integer',
            'categories' => 'required|array',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validação da imagem
        ]);

        $book = Book::findOrFail($id);

        // Verificar se há uma nova imagem e deletar a antiga
        if ($request->hasFile('cover_image')) {
            // Deletar a imagem antiga
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }

            // Salvar a nova imagem
            $imagePath = $request->file('cover_image')->store('images', 'public');
            $validatedData['cover_image'] = $imagePath;
        }

        $book->update($validatedData);
        $book->categories()->sync($request->categories);

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso!');
    }

    // Função para excluir um livro do banco de dados
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // Deletar a imagem associada
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->categories()->detach();
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso!');
    }
}


