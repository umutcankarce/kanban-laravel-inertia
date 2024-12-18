<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function store()
    {
        request()->validate([
            "board_id" => ["required","exists:boards,id"],
            "card_list_id" => ["required","exists:card_lists,id"],
            "title" => ["required"],
        ]);

        Card::create([
            "board_id" => request()->input("board_id"),
            "card_list_id" => request()->input("card_list_id"),
            "title" => request()->input("title"),
            "user_id" => auth()->id()
        ]);

        return redirect()->back();
    }

    public function update(Card $card)
    {
        request()->validate([
            "title" => ["required"]
        ]);

        $card->update([
            "title" => request()->input("title")
        ]);

        return redirect()->back();
    }

    public function move(Card $card)
    {
        request()->validate([
            'cardListId' => ['required','exists:card_lists,id'],
            'position' => ['required','numeric']
        ]);

        $card->update([
            'card_list_id' => request()->input('cardListId'),
            'position'     => round(request()->input('position'),5)
        ]);

        return redirect()->back();
    }
}
