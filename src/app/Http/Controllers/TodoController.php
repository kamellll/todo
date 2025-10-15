<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Category;
use App\Http\Requests\TodoRequest;
class TodoController extends Controller
{
    public function index()
    {
        //$todos = Todo::all();
        //↓todoモデルのレコードとそれに紐づくcategoryテーブルのレコードを取得します。
        $todos = Todo::with('category')->get();
        $categories = Category::all();
        //return view('index', ['todos'=>$todos]);
        return view('index', compact('todos', 'categories'));
    }
    public function store(TodoRequest $request)
    {
        $todo = $request->only(['content', 'category_id']);
        Todo::create($todo);
        //return redirect('/');
        //regirectメソッドでメッセージを送るときはwithメソッドを使う
        return redirect('/')->with('message', 'Todoを作成しました');
    }
    public function update(TodoRequest $request)
    {
        $todo = $request->only(['content']);
        Todo::find($request->id)->update($todo);

        //フォームの送信だから、画面遷移はリダイレクトを使い、メッセージも送信したいときはwithを使う
        return redirect('/')->with('message', 'Todoを更新しました');
    }
    public function destroy(Request $request)
    {
        Todo::find($request->id)->delete();

        //フォームの送信だから、画面遷移はリダイレクトを使い、メッセージも送信したいときはwithを使う
        return redirect('/')->with('message', 'Todoを削除しました');
    }
}
