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
    
    // Laravel は、ルーティング定義の URL の中括弧で囲まれたキーワード（{folder}）とコントローラーメソッドの仮引数名（$folder）が一致していて、かつ引数が型指定（Folder）されていれば、URL の中括弧で囲まれた部分の値を ID とみなし、自動的に引数の型のモデルクラスインスタンスを作成します。
    // ルートとコントローラーを結びつけるバインディング機能
    // iはweb.phpに書いたものが使用されています
    public function index(Folder $folder)
    {
        // ユーザーに紐づいたフォルダーを取得してくる
        $folders = Auth::user()->folders()->get();

        // $current_folder = Folder::find($i);
        $tasks = $folder->tasks()->get();
        // 第二引数に配列が入る。今回の場合は"folders"これをビュー側で使うときに$foldersとして使用できる。
        return view('tasks/index',[
            'folders' => $folders,
            'current_folder_id' => $folder->id,
            'tasks' => $tasks,
         ]);
    }

    public function showCreateForm(Folder $folder)
    {
        // tasks/createはタスクのクリエイトを指定している。routesに定義されたものは使えない。
        return view('tasks/create', ['folder_id' => $folder->id,]);
    }


    // CreatTaskに基づいてバリデーションされながらcreateしていく
    public function create(Folder $folder, CreateTask $request)
    {

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $folder->tasks()->save($task);

        // ここに設定されているidはどこで使われるものなのか
        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }

    // Folder $folderこれがないと編集できない。初期値として必要としている。
    public function showEditForm(Folder $folder, Task $task)
    {
        $this->check($folder, $task);
        // 'task'がなんの働きをしているかわからない
        return view('tasks/edit', ['task' => $task,]);
    }

    // int $folderこれがないと編集できない。初期値として必要としている。
    public function edit(Folder $folder, Task $task, EditTask $request)
    {
        $this->check($folder, $task);

        $task->title = $request->title;
        $task->due_date = $request->due_date;
        $task->status = $request->status;
        $task->save();

        // iがなんの働きをしているか知りたい
        return redirect()->route('tasks.index', ['i' => $task->folder_id,]);

    }

    private function check(Folder $folder, Task $task)
    {
        if($folder->id !== $task->folder_id){
            abort(404);
        }
    }

    
}
