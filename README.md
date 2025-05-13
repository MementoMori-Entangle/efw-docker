# EFW

2019年から放置していたものの、IT業界復帰に向けて2025年版として  
dokler-composeでlaravelとして作り直してみました。

# Step1
・テンプレート作成  
mkdir efw-docker  
cd efw-docker  

・.envとdocker-compose.yml作成

mkdir docker-config  
cd docker-config  
mkdir nginx  
mkdir php  

cd nginx

・Dockerfileとdefault.conf作成

cd ../php

・Dockerfileとphp.ini作成

・イメージ作成起動  
docker-compose up -d

・コンテナ接続  
docker exec -it efw bash

・laravel作成  
composer create-project --prefer-dist laravel/laravel efw

・ストレージオーナー修正  
chown www-data storage/ -R

構築工程を分かりやすくするため、efw(laravel)以外をgit push

# Step2

・.env修正(DB設定)

・efwにlaravel-adminをインストール  
composer require encore/laravel-admin --with-all-dependencies

php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"

php artisan admin:install

・efwにauthをインストール  
composer require laravel/ui

php artisan ui bootstrap --auth

php artisan migrate

php artisan make:controller UserController

・UserControllerを/app直下にインストールされたlaravel-adminに移動

cd app/Http/Controllers

mv UserController.php ../../Admin/Controllers/UserController.php

・UserController.phpをlaravel-adminに対応修正

・laravel.logオーナー修正  
cd /var/www/efw/storage/logs  
chown www-data laravel.log -R

・config/filesystems.phpにadmin追加

・adminのroutes.phpにユーザー追加

・Viteの関連で以下対応  
npm install && npm run dev (npm install && npm run build)

http://localhost:81/

右上ヘッダにLog in Registerが追加

http://localhost:81/admin/

Laravel-admin画面ログインしDB接続に問題ないことを確認

・adminメニューにUser追加  
routes.phpで設定したルート

・追加したユーザー画面でログイン用ユーザー作成

・ログインできるか確認  
http://localhost:81/login

http://localhost:81/homeにアクセスできればStep2完了

・構築工程を分かりやすくするため、efwの基本ファイル以外をgit push  
efw/  
＋ app/  
－ bootstrap/  
＋ config/  
＋ database/  
－ lang/  
－ node_modules/  
＋ public/  
＋ resources/  
＋ routes/  
－ storage/  
－ tests/  
－ vendor/

# Step3

・FabricJSの各機能を自前でサンプル実装したPHP+JSをlaravelに移植

背景  
物品配置をユーザー視点で行い、カスタマイズ配置品を提供する  
アプリのライブラリJSに使えるか検証するために作成  

初期実装時はFabricJSバージョン2.4.0、2025年5月現在は最新バージョン6系となり、  
バージョン2～5とは完全に別物となっているため、5.3を適用し様子見したい。  
ただし、ビデオストリームの取り扱いが変わったのか、動画関連部分が正常に動作しない場合がある。(特にwebカメラ)  
最終的には、バージョン6に移行する必要があるが、作り直しするに100時間以上はかかる見込み


・fabricコンテンツ用DB追加  
php artisan make:migration create_fabrics_table  
php artisan make:migration create_fabric_images_table

・DB定義追記

php artisan migrate

・モデル追加  
php artisan make:model Fabric  
php artisan make:model FabricImage

・コントローラー追加  
php artisan make:controller FabricController

・FabricControllerにauth(ミドルウェア)と(CRD)追加  
index、store、destroy

・Util.php作成(一先ずapp直下)

・config修正  
app.phpのtimezoneをAsia/Tokyo、localeをjaに変更  
auth.phpのguardsにapi追加

・routes/web.phpにルート追加

・welcome.blade.php修正

・home.blade.php修正

・layout.blade.php追加(共通用)

・fabric.blade.php追加

・publicオーナー修正  
cd /var/www/efw/  
chown www-data public -R

・パーミッション修正  
chmod 755 ajax  
chmod 755 build  
chmod 755 childwindow  
chmod 755 css  
chmod 755 font  
chmod 755 img  
chmod 755 js  
chmod 755 output  
chmod 755 svg  
chmod 755 upload  
chmod 755 uploads  
chmod 755 vendor  
chmod 755 video

・ファイル一覧

/efw/app/Admin/routes.php 修正  
/efw/app/Admin/Controllers/UserController.php 修正  
/efw/app/Http/Controllers/FabricController.php 新規追加  
/efw/app/Models/Fabric.php 新規追加  
/efw/app/Models/FabricImage.php 新規追加  
/efw/app/Util.php 新規追加  
/efw/config/app.php 修正  
/efw/config/auth.php 修正  
/efw/config/filesystems.php 修正  
/efw/database/migrations/2025_05_13_151114_create_fabrics_table.php 新規追加  
/efw/database/migrations/2025_05_13_151118_create_fabric_images_table.php 新規追加  
/efw/public/ajax/* 新規追加  
/efw/public/childwindow/* 新規追加  
/efw/public/css/fabric.css 新規追加  
/efw/public/img/* 新規追加  
/efw/public/js/color16Array.js 新規追加  
/efw/public/js/contextMenuUtil.js 新規追加  
/efw/public/js/fabricUtil.js 新規追加  
/efw/public/js/languageArray.js 新規追加  
/efw/public/upload/weave/* 新規追加  
/resources/views/layouts/app.blade.php 修正  
/resources/views/fabric.blade.php 新規追加  
/resources/views/home.blade.php 修正  
/resources/views/layout.blade.php 新規追加  
/resources/views/welcome.blade.php 修正  
/efw/routes/web.php 修正  
/efw/.env 修正
