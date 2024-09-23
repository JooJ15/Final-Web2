<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $bookId)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        Comment::create([
            'book_id' => $bookId,
            'comment' => $request->input('comment'),
            // Aqui deixamos o 'user_id' nulo, pois é anônimo
            //'user_id' => null,
        ]);

        return redirect()->route('books.show', $bookId)->with('success', 'Comentário adicionado com sucesso!');
    }
}

