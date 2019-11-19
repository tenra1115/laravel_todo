<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\CreateTask;
use App\Folder;
use App\Http\Requests\EditTask;
use App\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // iはweb.phpに書いたものが使用されています
    public function index(int $i)
    {
        // ユーザーに紐づいたフォルダーを取得してくる
        $folders = Auth::user()->folders()->get();

        $current_folder = Folder::find($i);
        $tasks = $current_folder->tasks()->get();
        // 第二引数に配列が入る。今回の場合は"folders"これをビュー側で使うときに$foldersとして使用できる。
        return view('tasks/index',[
            'folders' => $folders,
            'current_folder_id' => $current_folder->id,
            'tasks' => $tasks,
         ]);
    }

    public function showCreateForm(int $i)
    {
        // tasks/createはタスクのクリエイトを指定している。routesに定義されたものは使えない。
        return view('tasks/create', ['folder_id' => $i]);
    }


    // CreatTaskに基づいてバリデーションされながらcreateしていく
    public function create(int $i, CreateTask $request)
    {
        $current_folder = Folder::find($i);

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $current_folder->tasks()->save($task);

        // ここに設定されているidはどこで使われるものなのか
        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }

    // int $iこれがないと編集できない。初期値として必要としている。
    public function showEditForm(int $i, int $task_id)
    {
        $task = Task::find($task_id);

        return view('tasks/edit', ['task' => $task,]);
    }

    // int $iこれがないと編集できない。初期値として必要としている。
    public function edit(int $i, int $task_id, EditTask $request)
    {
        $task = Task::find($task_id);

        $task->title = $request->title;
        $task->due_date = $request->due_date;
        $task->status = $request->status;
        $task->save();

        // /folders/{i}/tasksの{i}の部分に当たるもの？
        return redirect()->route('tasks.index', ['i' => $task->folder_id,]);

    }

    
}
