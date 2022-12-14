<?php

namespace App\Http\Controllers\Draggable;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $query = Card::query();

        return response()->json([
            'data' => $query->get()
        ]);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        Card::query()->create([
            'column_id' => $request->columnId,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Successfully Created'
        ]);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        Card::query()->findOrFail($id)->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json([
            'message' => 'Successfully updated'
        ]);
    }

    public function updateCardPosition(Request $request)
    {
        $cards = $request->cards;
        foreach ($cards as $key => $card) {
            Card::query()->findOrFail($card['id'])->update([
                'order' => $key + 1,
                'column_id' => $request->column_id
            ]);
        }
        return response()->json([
            'message' => 'Card positions successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
