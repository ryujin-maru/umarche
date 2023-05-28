<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LifeCycleController extends Controller
{
    public function showService() {
        // app()->bind('lifeCycleTest',function() {
        //     return 'ライフサイクルテスト';
        // });
        // $test = app('lifeCycleTest');

        // app()->bind('sample',Sample::class);
        // $sample = app()->make('sample');
        // $sample->run();

        $encrypt = app()->make('encrypter');
        $password = $encrypt->encrypt('password');
        dd($password,$encrypt->decrypt($password));

        dd(app());
    }
}

class Sample {
    public $message;
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function run() {
        $this->message->send();
    }
}

class Message {
    public function send() {
        echo('メッセージ表示');
    }
}
