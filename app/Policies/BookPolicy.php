<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    
     //Determine whether the user can view any models.
     
    public function viewAny(User $user): bool
    {
        // Todos podem visualizar, se quiser permitir a todos
        return true;
    }

    
     //Determine whether the user can view the model.
    
    public function view(User $user, Book $book): bool
    {
        // Todos podem visualizar, ou você pode ajustar a lógica aqui
        return true;
    }

    
     //Determine whether the user can create models.
     
    public function create(User $user): bool
    {
        return true;
    }
        // Apenas admin e bibliotecario podem criar, esse conteudo e a linha de baixo é para o create
        //return $user->isAdmin() || $user->isBibliotecario();
    
     //Determine whether the user can update the model.
    
    public function update(User $user, Book $book): bool
    {
        // Apenas admin e bibliotecario podem editar
        return $user->isAdmin() || $user->isBibliotecario();
    }

    
    //Determine whether the user can delete the model.
     
    public function delete(User $user, Book $book): bool
    {
        // Apenas admin pode deletar
        return $user->isAdmin();
    }

    
     //Determine whether the user can restore the model.
    
    public function restore(User $user, Book $book): bool
    {
        // Pode usar a mesma lógica de delete, se aplicável
        return $user->isAdmin();
    }

    
    //Determine whether the user can permanently delete the model.
    
    public function forceDelete(User $user, Book $book): bool
    {
        // Apenas admin pode deletar permanentemente
        return $user->isAdmin();
    }
}
