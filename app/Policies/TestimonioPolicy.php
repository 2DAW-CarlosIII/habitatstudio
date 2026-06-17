<?php

namespace App\Policies;

use App\Models\User;
use App\Models\testimonio;
use Illuminate\Auth\Access\Response;

class TestimonioPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, testimonio $testimonio): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return  $user->testimonios->count() > 0;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, testimonio $testimonio): bool
    {

        return $testimonio->fecha_aprobacion == null && $user->testimonios->count() > 0;
        /* ermitir editar un testimonio propio solo si no está aprobado
( fecha_aprobacion  es  NULL ). -  */
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, testimonio $testimonio): bool
    {

       return $user->id == $testimonio->user_id && $user->testimonios->count() > 0;
    }
    /* ] Si ya está aprobado: redirigir al  index  >con mensaje de error.
destroy  - [ ] Eliminar el testimonio que coincida con el  id  y pertenezca al usuario autenticado */

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, testimonio $testimonio): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, testimonio $testimonio): bool
    {
        return false;
    }
}
