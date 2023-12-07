## udemy Laravel講座

## ダウンロード方法

git clone

git clone https://github.com/ryujin-maru/stok.git

git clone ブランチを指定してダウンロードする場合

git clone -b ブランチ名 https://github.com/ryujin-maru/stok.git

もしくはzipファイルでダウンロードしてください

## インストール方法

- cd laravel_umarche
- composer install または composer update
- npm install
- npm run dev

.env.example をコピーして .env ファイルを作成

## インストール後の実施事項

画像のダミーデータは
public/imagesフォルダ内に
sample1.jpg 〜 sample6.jpg として
保存しています。

php artisan storage:link で
storageフォルダにリンク後、

storage/app/public/productsフォルダ内に
保存すると表示されます。
(productsフォルダがない場合は作成してください。)

ショップの画像も表示する場合は、
storage/app/public/shopsフォルダを作成し
画像を保存してください。

## section7の補足
決済のテストとしてstripeを利用しています。 必要な場合は .env にstripeの情報を追記してください。 (講座内で解説しています)

## section8の補足
メールのテストとしてmailtrapを利用しています。 必要な場合は .env にmailtrapの情報を追記してください。 (講座内で解説しています)

メール処理には時間がかかるので、 キューを使用しています。

必要な場合は php artisan queue:workで ワーカーを立ち上げて動作確認するようにしてください。 (講座内で解説しています)

