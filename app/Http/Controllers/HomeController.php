<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {

        // ユーザーを取得している
        $user = Auth::user();

        // 取得したユーザーに紐づいているフォルダーの１番を取得
        $folder = $user->folders()->first();

        // $folderがない場合の処理
        if(is_null($folder)) {
            return view('home');
        }

        // フォルダがあれば一覧にリダイレクトする
        return redirect()->route('tasks.index', [
            'id' => $folder->id,
         ]);
    }
}
