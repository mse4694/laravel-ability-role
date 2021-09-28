<?php

namespace App\Http\Controllers;

use App\Models\OPDCard;
use Illuminate\Support\Facades\Auth;

class OPDCardsController extends Controller
{
    public function index()
    {
        $opdcards = OPDCard::all();
        $user = Auth::user();

        $opdcardsJSON = OPDCard::all()->transform( function($card) use ($user) {
            return [
                'hn' => $card->hn,
                'patient_name' => $card->patient_name,
                'triage_text' => $card->triage_test,
                'can' => [
                    'triage' => $user->can('triage', $card),
                    'exam' => $user->can('exam', $card),
                    'discharge' => $user->can('discharge', $card),
                    'procedure' => $user->can('procedure', $card),
                    'cancel' => $user->can('cancel', $card),
                ]
            ];
        });

        return view('opd-card.index', ['opdcards' => $opdcards, 'opdcardsJSON' => $opdcardsJSON]);
    }

    public function create()
    {
        return view('opd-card.create');
    }

    public function store()
    {
        OPDCard::create(request()->all());

        return redirect('/')->with('message', 'New case successfully created');
    }

    public function destroy(OPDCard $opdcard)
    {
        $opdcard->delete();

        return redirect('/')->with('message', 'Case canceled');
    }
}
