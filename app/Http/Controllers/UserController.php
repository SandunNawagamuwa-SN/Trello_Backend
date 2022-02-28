<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        if (Auth::user()->id !== $user->id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], 401);
        }

        return response()->json(['status' => 'success', 'user' => $user], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userId)
    {

        $this->validate($request,['name'=>'required','password'=>'required',]);

        if (Auth::user()->id != $userId) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], 401);
        }

        $user = User::find($userId);

        $user->name = $request['name'];

        $user->password = bcrypt($request['password']);

        $updated = $user->save();

        if($updated) {
            return response()->json(['message' => 'success', 'message' => 'updated successfully'], 200);
        }else {
            return response()->json(['message' => 'error', 'message' => 'something went wrong'], 500);
        }
        // return response()->json(['auth' => gettype(Auth::user()->id), 'send' => $updated], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId)
    {

        if (Auth::user()->id != $userId) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], 401);
        }
        
        if (User::destroy($userId)) {
            return response()->json(['status' => 'success', 'message' => 'User Deleted Successfully'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 500);

    }
}
