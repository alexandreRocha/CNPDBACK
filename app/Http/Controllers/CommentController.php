<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
   
    public function index()
    {
        //
    }
 
 
    public function fazerObs(Request $request)
    {
        $comment=new Comment();
        $comment->user_comment=Auth::user()->id;
        $comment->idp=$request->id;
        $comment->comments=$request->comments;
        $comment->estado="Novo";
        $comment->save();

        return back()->with('message', 'Observação feita com sucesso!'); 

    }
 
    public function show(Comment $comment)
    {
        //
    }

    
    public function edit(Comment $comment)
    {
        //
    }
 
    public function update(Request $request, Comment $comment)
    {
        //
    }
 
    public function destroy(Comment $comment)
    {
        //
    }
}
