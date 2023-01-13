<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogPostRequest;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        if(isset($request->author)) {
            $author = User::find($request->author);
            if ($author && $author->blogs()->count() > 0) {
                return $author->blogs()->orderBy('created_at', 'DESC')->paginate();
            } else {
                return response([
                    'message' => 'Author not found'
                ], 404);;
            }
        }

        return Blog::orderBy('created_at', 'DESC')->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPostRequest $request){

        $validated = $request->validated();

        // This could also be done in BlogPostRequest
        $validated['user_id'] = auth()->user()->id;
        return Blog::Create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){

        $blog = Blog::find($id);

        if ($blog) {
            return response($blog, 200);
        } else {
            return response([
                'message' => 'Blog not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogPostRequest $request, $id){

        $validated = $request->validated();
        $blog = Blog::find($id);
        $blog->update($validated);

        return $blog;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){

        $blog = Blog::find($id);

        if ($blog && $blog->user_id == auth()->user()->id) {
            $blog->delete();
            return response([
                'message' => 'Blog successfully removed'
            ], 200);
        } else {
            return response([
                'message' => 'Unauthorized delete attempt'
            ], 401);
        }
    }
}
