<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CardResource;

class CardController extends Controller
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
    public function index($boardId,$groupId)
    {
        $board=Board::find($boardId);

          if (Auth::user()->id !== $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], 401);
        }

        $group=$board->groups()->find($groupId);

        return response()->json(['status' => 'success' ,'cards' => CardResource::collection($group->cards)], 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $boardId, $groupId)
    {
        $this->validate($request,['name'=>'required', 'description'=>'required']);

        $board=Board::find($boardId);

        if (Auth::user()->id !== $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], 401);
        }

        $card = $board->groups()->find($groupId)->cards()->create([
            'name'    => $request->name,
            'description'  => $request->description,
        ]);

        if(empty($card)){
            return response()->json(['status' => 'error' ,'message' => 'something went wrong'], 500);
        }else{
            return response()->json(['status' => 'success' ,'message' => 'Board created successfully', 'card' => new CardResource($card)], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($boardId,$groupId,$cardId)
    {
        $board=Board::find($boardId);

          if (Auth::user()->id !== $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], 401);
        }

        $group = $board->groups()->find($groupId);
        
        $card=$group->cards()->find($cardId);

        if($card){
            return response()->json(['message' => 'success', 'card' => new CardResource($card)], 200);
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
    public function update(Request $request, $boardId, $groupId, $cardId)
    {

        $this->validate($request,['name'=>'required','description'=>'required']);

        $board = Board::find($boardId);

        if (Auth::user()->id !== $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], 401);
        }
        
        $card = $board->lists()->find($groupId)->cards()->find($cardId);
        
        $card->name = $request['name'];

        $card->description = $request['description'];

        $updated = $card->save();

        if($updated) {
            return response()->json(['message' => 'success', 'message' => 'updated successfully', 'card' => new CardResource($card)], 200);
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
    public function destroy($boardId,$groupId,$cardId)
    {
        $board=Board::find($boardId);

        if(Auth::user()->id !== $board->user_id) {
            return response()->json(['status'=>'error','message'=>'unauthorized'],401);
        }
        $card=$board->groups()->find($groupId)->cards()->find($cardId);

        if ($card->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Card Deleted Successfully'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 500);

    }
}
