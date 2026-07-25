# debugging-app-practice

## 概要

COACHTECH 教材 Tutorial 10-4「デバッグ ハンズオン演習」で作成した成果物です。
gitでクローンしたユーザー登録フォームについて、エラー表示を読み取り適切な修正を行う演習を行いました。

## 使用技術

- PHP 8.x
- Laravel 10.x
- デバッグツール（`dd()`, `dump()`, `Log` ファサード）

## 学んだこと

- ブラウザに表示されるエラーメッセージの読み取りや適切な修正の仕方
- デバッグツールによる開発中の入力データの確認、本番環境でのログの見方など

## エラーの修正について

- 提供されたプロジェクトの動作（マスアサインメントが設定されていないのでstoreでエラー表示になります。）
  <img width="1894" height="1128" alt="Image" src="https://github.com/user-attachments/assets/f48977ed-5559-43b3-98ca-3a2c0427a4bf" />

- エラーの修正（マスアサインメント($fillable)をUserモデルで設定します。）
```
    // マスアサインメント（$fillable）の有効化
    protected $fillable = ['name', 'email', 'password'];
```

<動作確認>
<img width="1908" height="1122" alt="Image" src="https://github.com/user-attachments/assets/d64cd785-621a-440f-8b0e-1af40f916a8f" />

## デバッグツール(dd()やLogファサード)による送信データやエラーメッセージの確認

- dd()での送信データの確認
  ・コード( App/Http/Controller/UserController.php )

```
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // 入力データの確認（処理はここで終わる）
        dd($request->all());

        return redirect('/users');
    }
```    

<ブラウザでの表示画面>
<img width="425" height="433" alt="Image" src="https://github.com/user-attachments/assets/ee84bf22-c006-4d92-86d6-a12a4c791799" />

送信しようとする$userデータの詳細を表示しますが、passwordはhash化かつhidden設定になっていることがわかります。

- Logファサードによる正常時とエラー時のメッセージの記録  
  ・コード( App/Http/Controller/UserController.php )

```
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
```

<Logの確認-登録成功時( storage/logs/laravel.log )>
<img width="829" height="37" alt="Image" src="https://github.com/user-attachments/assets/2cd8734b-602e-49c1-88f1-0b0319c4354f" />

## 動作確認

http://localhost/users/create にアクセスしてフォームを送信
