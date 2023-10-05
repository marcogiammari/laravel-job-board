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

    public function viewAnyEmployer(User $user): bool
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
        return $user->employer !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Job $job): bool|Response
    {
        if ($job->employer->user_id !== $user->id) {
            return false;
        }

        // se usi jobApplications come property (senza parentesi) laravel andrà a prendere tutti i model e solo alla fine ritornerà il conteggio:
        // select * from `job_applications` where `job_applications`.`job_id` = 102 and `job_applications`.`job_id` is not null
        // se usi jobApplications() come method partirà una query COUNT * etc molto più efficiente:
        // select count(*) as aggregate from `job_applications` where `job_applications`.`job_id` = 102 and `job_applications`.`job_id` is not null

        if ($job->jobApplications()->count() > 0) {
            return Response::deny('Cannot change a job with applications');
        }
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Job $job): bool
    {
        return $job->employer->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Job $job): bool
    {
        return $job->employer->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Job $job): bool
    {
        return $job->employer->user_id === $user->id;
    }
}
