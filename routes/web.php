<?php

use Illuminate\Support\Facades\Route;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $tasks = Task::orderBy('created_at', 'asc')->get();
 
    return view('welcome', [
        'tasks' => $tasks
    ]);
});

Route::get('/task', function (Request $request) {
    return view('addtaskform');
})->name('addtaskform');
/**
 * Add New Task
 */
Route::post('/task', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
    ]);
 
    if ($validator->fails()) {
        return redirect('/');
    }
    $task = new Task;
    $task->name = $request->name;
    $task->save();
 
    return redirect('/');
});
 
/**
 * Delete Task
 */
Route::delete('/task/{task}', function (Task $task) {
    $task->delete();
 
    return redirect('/');
});