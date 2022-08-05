<?php

namespace App\Http\Controllers\Draggable;

use App\Http\Controllers\Controller;
use App\Models\Column;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($access_token, $date, $status): \Illuminate\Http\JsonResponse
    {

        if($access_token !== env('ACCESS_TOKEN')) {
            return response()->json([
                'data' => []
            ]);
        }


        $query = Column::query()->with('cards');

        if(isset($status) && $status == 'true' ) {
            $query->withTrashed();
        }

        if(isset($date) && $date != 'null' ) {
            $query->whereDate('created_at', $date);
        }

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
        Column::query()->create([
            'title' => $request->title
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        Column::query()->findOrFail($id)->delete();

        return response()->json([
            'message' => 'Successfully Deleted'
        ]);
    }
}
