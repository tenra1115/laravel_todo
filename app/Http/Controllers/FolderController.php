<?php

namespace App\Http\Controllers;

// フォルダーモデルを読み込み
use App\Folder;
// フォームリクエストを読み込み
use App\Http\Requests\CreateFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    public function showCreateForm()
    {
        return view('folders/create');
    }

    // フォルダーを作成するときはCreateFolderにしたがって作成される。上に定義させる必要がある。
    public function create(CreateFolder $request)
    {
        $folder = new Folder();

        $folder->title = $request->title;

        // 作成するフォルダーをユーザーに紐付ける
        Auth::user()->folders()->save($folder);

        // iはどこで必要とされているのか？tasks.indexの何で必要なのか？
        return redirect()->route('tasks.index', ['i' => $folder->id,]);
    }
}
