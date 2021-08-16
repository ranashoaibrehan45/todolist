<?php

namespace App\Http\Controllers;

use App\Events\ColumnDeleted;
use Illuminate\Http\Request;
use App\Http\Requests\ColumnRequest;
use App\Models\Column;
use App\Models\Card;
use Log;
use DB;


class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Column::orderBy('created_at')
            ->with('cards')
            ->get();
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
    public function store(ColumnRequest $request)
    {
        $column = Column::create($request->all());
        if ($column->id > 0) {
            return $this->index();
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ColumnRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $column = Column::find($id);
        if ($column) {
            try {
                DB::beginTransaction();
                if ($column->cards()->delete()) {
                    if ($column->delete()) {
                        DB::commit();
                    } else {
                        DB::rollback();
                    }
                    return $this->index();
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
                DB::rollback();
                return false;
            }
        }
    }

    public function sortCards(Request $request)
    {
        switch ($request->input('move')) {
            case 'up':
                $card = Card::find($request->input('card_id'));
                $upperCard = Card::where('sort_order', '<', $card->sort_order)
                    ->where('column_id', $request->input('column_id'))
                    ->orderBy('sort_order', 'desc')
                    ->first();
                $upperCardSortorder = $upperCard->sort_order;
                $upperCard->sort_order = $card->sort_order;
                $upperCard->save();

                $card->sort_order = $upperCardSortorder;
                $card->save();
                break;
            case 'right':
                $card = Card::find($request->input('card_id'));
                $column = Column::where('id', '>', $card->column_id)
                    ->orderBy('id')
                    ->first();
                if ($column) {
                    $card->column_id = $column->id;
                    $card->sort_order = $card->getSortOrder();
                    $card->save();
                }
                break;
            case 'down':
                $card = Card::find($request->input('card_id'));
                $upperCard = Card::where('sort_order', '>', $card->sort_order)
                    ->where('column_id', $request->input('column_id'))
                    ->orderBy('sort_order', 'asc')
                    ->first();
                $upperCardSortorder = $upperCard->sort_order;
                $upperCard->sort_order = $card->sort_order;
                $upperCard->save();

                $card->sort_order = $upperCardSortorder;
                $card->save();
                break;
            case 'left':
                $card = Card::find($request->input('card_id'));
                $column = Column::where('id', '<', $card->column_id)
                    ->orderBy('id', 'desc')
                    ->first();
                if ($column) {
                    $card->column_id = $column->id;
                    $card->sort_order = $card->getSortOrder();
                    $card->save();
                }
                break;
                break;
        }
        return $this->index();
    }
}
