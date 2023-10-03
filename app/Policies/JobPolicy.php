<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\Response;

// convenzione laravel: se usi lo stesso nome del model non hai bisogno di registrare la policy in AuthServiceProvider e non devi richiamare le actions del controller e collegarle ai metodi della policy
class JobPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // settiamo lo user come opzionale: non devi essere autenticato per vedere gli annunci
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Job $job): bool
    {
        return true;
    }

    // verifichiamo che l'utente non abbia già applicato per il lavoro
    // creiamo il metodo apply qui e non in JobApplication
    // una JobApplication non può esistere senza un Job
    public function apply(User $user, Job $job): bool
    {
        return !$job->hasUserApplied($user);
    }

    // ritorniamo false per le action/funzionalità non presenti sull'app

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Job $job): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Job $job): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Job $job): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Job $job): bool
    {
        return false;
    }
}
