<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Comment;
use JWTAuth;
class CommentsController extends Controller
{
    // public function store(Request $request, $task_id)
    // {
    // 	$this->validate($request, array(
    // 		'body'=>'required|max:2000'
    // 		));

    // 	$comment = new Comment();
    // 	$comment->user_id = auth()->id();
    // 	$comment->task_id = $task_id; //ova $task_id e id-to na taskot
    //     $comment->body = $request->body;
    // 	$comment->save();

    // 	return redirect()->route('singleTask', $task_id);
    	
    // }

    public function storeComment(Request $request, $task_id)
    {
        $user = JWTAuth::parseToken()->toUser();
        $comment = new Comment();
        $comment->user_id=$user->id;
        $comment->task_id = $task_id; //ova $task_id e id-to na taskot
        $comment->body = $request->body;
        $comment->save();
        return response()->json(['comment'=>$comment],201);
    }
}
