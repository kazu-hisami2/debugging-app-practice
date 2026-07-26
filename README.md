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
  
エラー時のスタックトレース( Storage/logs/laravel.php )
```
[2026-07-25 06:36:01] local.ERROR: Add [name] to fillable property to allow mass assignment on [App\Models\User]. {"exception":"[object] (Illuminate\\Database\\Eloquent\\MassAssignmentException(code: 0): Add [name] to fillable property to allow mass assignment on [App\\Models\\User]. at /var/www/html/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:525)
[stacktrace]
#0 /var/www/html/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(614): Illuminate\\Database\\Eloquent\\Model->fill()
#1 /var/www/html/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php(1539): Illuminate\\Database\\Eloquent\\Model->newInstance()
#2 /var/www/html/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php(1024): Illuminate\\Database\\Eloquent\\Builder->newModelInstance()
#3 /var/www/html/vendor/laravel/framework/src/Illuminate/Support/Traits/ForwardsCalls.php(23): Illuminate\\Database\\Eloquent\\Builder->create()
#4 /var/www/html/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(2335): Illuminate\\Database\\Eloquent\\Model->forwardCallTo()
#5 /var/www/html/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(2347): Illuminate\\Database\\Eloquent\\Model->__call()
#6 /var/www/html/app/Http/Controllers/UserController.php(24): Illuminate\\Database\\Eloquent\\Model::__callStatic()
#7 /var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Controller.php(54): App\\Http\\Controllers\\UserController->store()
#8 /var/www/html/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php(43): Illuminate\\Routing\\Controller->callAction()
#9 /var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php(259): Illuminate\\Routing\\ControllerDispatcher->dispatch()
#10 /var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php(205): Illuminate\\Routing\\Route->runController()
#11 /var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php(806): Illuminate\\Routing\\Route->run()
#12 /var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Routing\\Router->{closure:Illuminate\\Routing\\Router::runRouteWithinStack():805}()
#13 /var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php(50): Illuminate\\Pipeline\\Pipeline->{closure:Illuminate\\Pipeline\\Pipeline::prepareDestination():142}()
#14 /var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(183): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle()
#15 /var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php(78): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():158}:159}()
#16 /var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken->handle()
#17 /var/www/html/vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php(49): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():158}:159}()
#18 /var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(183): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle()
#19 /var/www/html/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(121): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():158}:159}()
#20 /var/www/html/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(64): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest()
#21 /var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(183): Illuminate\\Session\\Middleware\\StartSession->handle()
#22 /var/www/html/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php(37): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():158}:159}()
#23 /var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(183): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle()
#24 /var/www/html/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php(67): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():158}:159}()
#25 /var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(183): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle()
#26 /var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():158}:159}()
#27 /var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php(805): Illuminate\\Pipeline\\Pipeline->then()
#28 /var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php(784): Illuminate\\Routing\\Router->runRouteWithinStack()
#29 /var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php(748): Illuminate\\Routing\\Router->runRoute()
#30 /var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php(737): Illuminate\\Routing\\Router->dispatchToRoute()
#31 /var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(200): Illuminate\\Routing\\Router->dispatch()
#32 /var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(144): Illuminate\\Foundation\\Http\\Kernel->{closure:Illuminate\\Foundation\\Http\\Kernel::dispatchToRouter():197}()
#33 /var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->{closure:Illuminate\\Pipeline\\Pipeline::prepareDestination():142}()
#34 /var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle()
#35 /var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle()
#36 /var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():158}:159}()
#37 /var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php(40): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle()
#38 /var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle()
#39 /var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():158}:159}()
#40 /var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle()
#41 /var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php(99): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():158}:159}()
#42 /var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(183): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle()
#43 /var/www/html/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php(49): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():158}:159}()
#44 /var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(183): Illuminate\\Http\\Middleware\\HandleCors->handle()
#45 /var/www/html/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php(39): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():158}:159}()
#46 /var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(183): Illuminate\\Http\\Middleware\\TrustProxies->handle()
#47 /var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():158}:159}()
#48 /var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(175): Illuminate\\Pipeline\\Pipeline->then()
#49 /var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(144): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter()
#50 /var/www/html/public/index.php(51): Illuminate\\Foundation\\Http\\Kernel->handle()
#51 /var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php(16): require_once('...')
#52 {main}
"} 
```

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
