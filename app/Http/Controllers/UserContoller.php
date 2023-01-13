<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserContoller extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $user = User::find($id);
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        $user->update($validated);
        return $user;
    }


    public function destroy(Request $request, $id){
        $user = User::find($id);

        if ($user) {
            $request->user()->currentAccessToken()->delete();
            // This will trigger cascade delete of all blogs from this user
            $user->delete();
            return response([
                'message' => 'User successfully removed'
            ], 200);
        } else {
            return response([
                'message' => 'Unauthorized remove attempt'
            ], 401);
        }

        // Here should be some redirect maybe in case of spa
    }
}
