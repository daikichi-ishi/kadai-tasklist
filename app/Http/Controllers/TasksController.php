<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data = [];
        if (\Auth::check()) {
            
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'tasks' => $tasks,
                ];
        }
        
        
        
        return view('welcome', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //タスク作成ビュー
        $task = new Task;
        
        
        return view('tasks.create', ['task' => $task,]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //バリデーション
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:255'
            ]);
        
        //タスクを登録処理
        $request->user()->tasks()->create([
            'status' => $request->status, 
            'content' =>$request->content, 
        ]);
        
        //トップページへリダイレクト
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //idの値でタスクを取得
        $task = Task::findOrFail($id);
         if (\Auth::id() === $task->user_id) {
             return view('tasks.show', ['task' => $task,]);
            
        }
        else{
            //トップページへリダイレクト
            return redirect('/');
        }
        
        
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //idの値でタスクを取得
        $task = Task::findOrFail($id);
        //削除
        if (\Auth::id() === $task->user_id) {
            return view('tasks.edit', ['task' => $task,]); 
            
        }
        else{
            //トップページへリダイレクト
            return redirect('/');
        }
        
            
        return back(); 
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //バリデーション
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:255'
            ]);
            
        //idの値で取得
        $task = Task::findOrFail($id);
        //タスクを更新
        if (\Auth::id() === $task->user_id) {
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save(); 
        }
        else{
            //トップページへリダイレクト
            return redirect('/');
        }
        
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //idの値で取得
        $task = Task::findOrFail($id);
        //削除
        if (\Auth::id() === $task->user_id) {
            $task->delete(); 
            
        }
        else{
            //トップページへリダイレクト
            return redirect('/');
        }
        
            
        return back();  
        
    }
}
