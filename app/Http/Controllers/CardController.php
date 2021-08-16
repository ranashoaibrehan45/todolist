<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CardRequest;
use App\Models\Card;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CardRequest $request)
    {
        $card = Card::create($request->all());
        if ($card->id > 0) {
            $sort_order = $card->getSortOrder();
            $card->sort_order = $sort_order;
            if ($card->save()) {
                return [
                    'success' => true,
                ];
            }
        }
        return [
            'success' => false,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $card = Card::find($id);
        if ($card) {
            return [
                'success' => true,
                'card' => $card,
            ];
        } else {
            return [
                'success' => false,
            ];
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CardRequest $request, $id)
    {
        $card = Card::find($id);
        if ($card) {
            if ($card->update($request->all())) {
                return [
                    'success' => true,
                ];
            } else {
                return [
                    'success' => false,
                ];
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $card = Card::find($id);
        if ($card) {
            if ($card->delete()) {
                return [
                    'success' => true,
                ];
            } else {
                return [
                    'success' => false,
                ];
            }
        }
    }
}
