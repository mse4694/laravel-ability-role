<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OPDCard;
use Illuminate\Auth\Access\HandlesAuthorization;

class OPDCardPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // triage_case
    public function triage(User $user, OPDCard $opdcard) {
        return $user->abilities->contains('triage_case')
               && ! $opdcard->triage;
    }

    // exam_case
    public function exam(User $user, OPDCard $opdcard) {
        return $user->abilities->contains('exam_case')
               && $opdcard->triage
               && ! $opdcard->exam_completed_at;
    }

    // procedure_case
    public function procedure(User $user, OPDCard $opdcard) {
        return $user->abilities->contains('procedure_case')
               && $opdcard->triage
               && ! $opdcard->exam_completed_at;
    }

    // discharge_case
    public function discharge(User $user, OPDCard $opdcard) {
        return $user->abilities->contains('discharge_case')
               && $opdcard->exam_completed_at;
    }

    // cancel_case
    public function cancel(User $user, OPDCard $opdcard) {
        return $user->abilities->contains('cancel_case')
               && ! $opdcard->exam_completed_at;
    }

    // view_individual_case
    public function view_individual(User $user, OPDCard $opdcard) {
        if ( strcmp($user->name, "gp_md") === 0 ) {
            return $user->abilities->contains('view_individual_case')
                    && $opdcard->triage >= 3 
                    && $opdcard->triage <= 5; 
        } elseif ( strcmp($user->name, "er_md") === 0 ) {
            return $user->abilities->contains('view_individual_case') 
                    && $opdcard->triage >= 1
                    && $opdcard->triage <= 2;
        } else {
            return $user->abilities->contains('view_individual_case');
        }
        // return $user->abilities->contains('view_individual_case')
        //        && ! $opdcard->exam_completed_at;
    }



    // public function exam(User $user, OPDCard $opdcard) {
    //     return $opdcard->triage;
    // }
}
