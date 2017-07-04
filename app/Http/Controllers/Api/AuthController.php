<?php
/**
 * Created by PhpStorm.
 * User: MrCong <i@cong5.net>
 * Date: 2017/2/4
 * Time: 11:42
 */

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
/*use Persimmon\Storage\QiniuUploads;*/


class AuthController extends ApiController

{

    public function login(Request $request)
    {

        $post = $request->input();
        if (Auth::attempt(['email' => $post['email'], 'password' => $post['password']], $post['remember'])) {


            $check = Auth::check();

            $user = Auth::user();

            $data = ['msg' => '登录成功', 'user' => ['name' => $user['name'], 'token' => Session::getId(),]];

        }else{

            $this->setStatusCode(403);

            $data = ['msg' => '用户名或者密码不正确'];
        }

        return $this->respondWithArray($data);
        //return response()->json($data);

    }

    public function check()
    {
        //return app('auth')->guard('passport')->user();
        //return app('auth')->user();

        if (Auth::check()) {

            return response()->json(['auth' => 'Authenticated']);
        }

        return response()->json( ['auth' => 'Unauthenticated']);

    }

    public function logout()
    {
        Auth::logout();
        $data = [
            'status' => 200,
            'msg' => '退出成功',
        ];
        return response()->json($data);
    }

   public function getGravatar($user)
    {
        $date = str_ireplace('avatar_', '', !empty($user['avatar']) ? $user['avatar'] : 'avatar_1970-01-01');
        $carbon = Carbon::createFromTimestamp(strtotime($date))->addDays(30);
        if (empty($user['avatar']) || $carbon->toDateString() <= date('Y-m-d')) {
            $avatar = (new QiniuUploads())->cacheGravatar($user['email']);
            $user->avatar = $avatar;
            $user->save();
        } else {
            $avatar = $user['avatar'];
        }
        return $avatar;
    }

}