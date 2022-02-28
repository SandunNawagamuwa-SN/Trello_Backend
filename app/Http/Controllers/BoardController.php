<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BoardResource;

class BoardController extends Controller
{
    /**
     * Create a new controller instance
     * 
     * @return void
    */
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status' => 'success' ,'board' => BoardResource::collection(Auth::user()->boards)], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $board = Auth::user()->boards()->create([
            'name' => $request->name,
        ]);

        if(empty($board)){
            return response()->json(['status' => 'error' ,'message' => 'something went wrong'], 500);
        }else{
            return response()->json(['status' => 'success' ,'message' => 'Board created successfully', 'board' => new BoardResource($board)], 201);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($boardId)
    {
        $board = Board::find($boardId);
        
        if($board){
            if(Auth::user()->id !== $board->user_id) {
                return response()->json(['status' => 'error', 'message' => 'unathorized'], 401);
            }else {
                return response()->json(['message' => 'success', 'board' => new BoardResource($board)], 200);
            }
        }else {
            return response()->json(['message' => 'error', 'message' => 'something went wrong'], 500);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $boardId)
    {

        $this->validate($request,['name'=>'required|string']);

        $board = Board::find($boardId);
        
        if (Auth::user()->id !== $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], 401);
        }

        $board->name = $request['name'];

        $updated = $board->save();

        if($updated) {
            return response()->json(['message' => 'success', 'message' => 'updated successfully','board' => new BoardResource($board)], 200);
        }else {
            return response()->json(['message' => 'error', 'message' => 'something went wrong'], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($boardId)
    {
        $board = Board::find($boardId);

        if(Auth::user()->id !== $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unathorized'], 401);
        }

        if(Board::destroy($boardId)) {
            return response()->json(['status' => 'success', 'message' => 'Board Deleted Sucessfully'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 500);

    }
}
