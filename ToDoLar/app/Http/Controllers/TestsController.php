<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
class TestsController extends Controller
{
    public function quartTime()
    {
    	
    	$tasks=Task::all();
    	return view('tests.quartTime')->with('tasks',$tasks);
    }

}
