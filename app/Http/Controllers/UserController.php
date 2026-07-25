<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // 正常処理(try)、例外処理(catch)
        try {
            // 情報登録前にログを記録（passwordは除く）
            Log::info('ユーザー登録処理を開始します', [
                'input_data' => $request->except('password')
            ]);

            // リクエストされた情報をUserモデルに登録
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            // 登録成功時のログを記録
            Log::info('ユーザーの登録に成功しました', [
                'name' => $user->name,
                'email' => $user->email,
            ]);

            // ページの遷移
            return redirect('/users')->with('success', '登録が完了しました');

        } catch (\Throwable $e) {

            // エラー（例外時）ログの記録
            Log::error('ユーザー登録処理でエラーが発生しました', [
                'error_message' => $e->getMessage(), // エラー内容のメッセージ
                'file' => $e->getFile(),    // エラーが起きたファイル名
                'line' => $e->getLine(),    // エラーが起きた行数
                'input_data' => $request->except('password'), // どの入力値でエラーか
            ]);

            return back()->with('error', '登録処理に失敗しました');
        }
    }
}
