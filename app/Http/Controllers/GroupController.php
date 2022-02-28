<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\GroupResource;

class GroupController extends Controller
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
    public function index($boardId)
    {
        $board = Board::find($boardId);

        if(Auth::user()->id !== $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unathorized'], 401);
        }

        return response()->json(['status' => 'success' ,'groups' => GroupResource::collection($board->groups)], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($boardId, $groupId)
    {
        $board = Board::find($boardId);

        if(Auth::user()->id !== $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unathorized'], 401);
        }
        
        $group = $board->groups()->find($groupId);

        if($group){
            return response()->json(['status' => 'success', 'group' => new GroupResource($group)], 200);
        }else {
            return response()->json(['message' => 'error', 'message' => 'something went wrong'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $boardId)
    {
        $this->validate($request,['name' => 'required|string']);

        $board = Board::find($boardId);

        if(Auth::user()->id != $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unathorized'], 401);
        }

        $group = $board->groups()->create([
            'name' => $request->name,
        ]);

        if(empty($group)){
            return response()->json(['status' => 'error' ,'message' => 'something went wrong'], 500);
        }else{
            return response()->json(['status' => 'success' ,'message' => 'Board created successfully', 'group' => new GroupResource($group)], 201);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $boardId, $groupId)
    {

        $this->validate($request,['name'=>'required']);

        $board = Board::find($boardId);

        if (Auth::user()->id !== $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], 401);
        }

        $group = $board->groups()->find($groupId);

        $group->name = $request['name'];

        $updated = $group->save();

        if($updated) {
            return response()->json(['message' => 'success', 'message' => 'updated successfully', 'group' => new GroupResource($group)], 200);
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
    public function destroy($boardId,$groupId)
    {
        $board=Board::find($boardId);

        if(Auth::user()->id !== $board->user_id) {
            return response()->json(['status'=>'error','message'=>'unauthorized'],401);
        }
        $group=$board->groups()->find($groupId);

        if ($group->delete()) {
            return response()->json(['status' => 'success', 'message' => 'group Deleted Successfully'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 500);
    }

}
