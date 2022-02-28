<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
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
    public function index($boardId, $groupId, $cardId)
    {
        $board=Board::find($boardId);

          if (Auth::user()->id !== $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], 401);
        }

        $card = $board->groups()->find($groupId)->cards()->find($cardId);
        
        return response()->json(['status' => 'success' ,'comments' => CommentResource::collection($card->comments)], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $boardId, $groupId, $cardId)
    {
        $this->validate($request,['content'=>'required']);

        $board=Board::find($boardId);

        if (Auth::user()->id !== $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], 401);
        }

        $comment = $board->groups()->find($groupId)->cards()->find($cardId)->comments()->create([
            'content'    => $request->content,
        ]);

        if(empty($comment)){
            return response()->json(['status' => 'error' ,'message' => 'something went wrong'], 500);
        }else{
            return response()->json(['status' => 'success' ,'message' => 'Board created successfully', 'comment' => new CommentResource($comment)], 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($boardId,$groupId,$cardId,$commentId)
    {
        $board=Board::find($boardId);

        if(Auth::user()->id !== $board->user_id) {
            return response()->json(['status'=>'error','message'=>'unauthorized'],401);
        }
        $comment=$board->groups()->find($groupId)->cards()->find($cardId)->comments()->find($commentId);

        if ($comment->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Card Deleted Successfully'],200);
        }

        return response()->json(['status' => 'error', 'message' => 'Something went wrong'],500);

    }
}
