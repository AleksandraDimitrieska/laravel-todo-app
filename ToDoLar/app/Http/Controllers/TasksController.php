<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use JWTAuth;
use App\User;
class TasksController extends Controller
{
    public function getTasks()
    {
    	$tasks=Task::all();
        return response()->json(['tasks' => $tasks],201);
    }
    // public function create()
    // {
    // 	return view('tasks.create');
    // }
    public function postTask(Request $request)
    {

    	// $this->validate($request, array(
    	// 		'title' => 'required|max:255',
    	// 		'body' => 'required',
    	// 		'category' => 'required',
    	// 		'importancy' => 'required',
     //            'urgency' => 'required'
    	// 	));
    	//echo "<pre>"; var_dump($request->title);exit;
        //
        $tasks = Task::all();
        $user = JWTAuth::parseToken()->toUser();
    	$task = new Task();
        //$task->user_id = auth()->id();
        $task->user_id=$user->id;
    	$task->title = $request->input('title');
    	$task->body = $request->input('body');
    	$task->category = $request->input('category');
    	$task->importancy = $request->input('importancy');
        $task->urgency = $request->input('urgency');
        $task->isFinished = $request->input('isFinished');
    	$task->save();

    	return response()->json(['task'=>$task,'user'=>$user],201);
    }
    public function showTask($id)
    {
        $user = JWTAuth::parseToken()->toUser();
        $task = Task::find($id);
        $comments = $task->comments;
        return response()->json(['task'=>$task,'user'=>$user], 201);
    }
    // public function show($id)
    // {
    // 	$task = Task::find($id);
    // 	return view('tasks.show')->with('task',$task);
    	
    // }
    // public function edit($id)
    // {
    //     $task = Task::find($id);
    //     return view('tasks.edit')->with('task', $task);
    // }
    public function updateTask(Request $request, $id)
    {
        $task = Task::find($id);
        //dokolku ne se pronajde taskot
        if (!$task){  
            return response()->json(['message'=>'Document not found'], 404);
        }
        //dokolku se pronajde taskot
        $task->title = $request->input('title');
        $task->body = $request->input('body');
        $task->category = $request->input('category');
        $task->importancy = $request->input('importancy');
        $task->urgency = $request->input('urgency');
        $task->isFinished = $request->input('isFinished');
        $task->save();
        return response()->json(['task'=>$task],200);

    }
    public function deleteTask($id)
    {
        $task = Task::find($id);
        $task->delete();
        return response()->json(['message'=>'Task deleted'], 200);
    }

    // public function update(Request $request, $id)
    // {
        
    //     $this->validate($request, array(
    //         'title'=>'required',
    //         'body' => 'required',

    //         // 'category' => 'required',
    //         // 'importancy' => 'required'
    //     ));
        
    //     $task = new Task;
    //     $task->title=$request->input('title');
    //     $task->body = $request->input('body');
    //     // $task->category = $request->input('category');
    //     // $task->importancy = $request->input('importancy');
    //     $task->save();

    //     return redirect()->route('allTasks',$task->id);
 
    // }

    // public function delete($id)
    // {
    //     $task=Task::find($id);
    //     $task->delete();
    //     return redirect()->route('allTasks');
    // }
    
    public function isCompleted($id)
    {
        $task = Task::find($id);
        $task->isFinished = 1;
        $task->save();
        return response()->json('Task is completed');
    }

    public function isNotCompleted($id)
    {
        $task = Task::find($id);
        $task->isFinished = 0;
        $task->save();
        return response()->json('Task is not completed');
    }

    public function showComments($id)
    {
        $task = Task::find($id);
        //$comment = Comment::find($id);
        $comments = $task->comments;
        //$user = $comments->user; //ova e userot sto go kreiral komentarot, odnosno funkcijata user() sto e kreirana vo Comment.php modelot
        return response()->json(['comments' => $comments],201);
    }
    
    public function getUsers()//ke gi prakjame site users za da go izdvoime samo userot sto ni treba vo angularot barakji go negovoto id
    {
        $users = User::all();
        return response()->json(['users' => $users],201);

    }
    
  
    public function showUser($id)//mu go prakjame userot na taskot
    {
        $task = Task::find($id);
        $user = $task->user;
        //$user = JWTAuth::parseToken()->toUser();
        return response()->json(['user'=>$user],201); 
    }

    public function signout()
    {
        $token = JWTAuth::getToken();
        return JWTAuth::invalidate($token);
    }
   
}
