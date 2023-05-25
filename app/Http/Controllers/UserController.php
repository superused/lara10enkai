<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * @return void
     */

    public function __construct()
    {
        $this->middleware("auth");
    }

    /**
     * Diplay a listing of the resource
     * 
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $homeMenus = [];
        $homeMenus["イベント一覧"] = route("admin.event.index");
        $homeMenus["イベント新規登録"] = route("admin.event.create");
        $homeMenus["カテゴリ一覧"] = route("admin.category.index");
        $homeMenus["カテゴリ新規登録"] = route("admin.category.create");
        $users = User::simplePaginate(5);
        return view("user.index", compact("homeMenus","users"));
    }

    public function edit()
    {
        $id = \Auth::user()->id;
        $user = User::find($id);
        return view("user.edit", compact("user"));
    }

    public function update(Request $request)
    {
        $user = \Auth::user();
        $this->validate($request,[
            "name"=>["required", "string", "max:255"],
            "email" => ["required", "string", "email", "max:255", "unique:users,email," . $user->id],
        ]);
        $user->name = $request->input("name");
        $user->email = $request->input("email");        
        if($user->save()){
            $request->session()->flash("success", __("ユーザ情報を更新しました"));
        }else{
            $request->session()->flash("error",__("ユーザ情報の更新に失敗しました"));
        }

        return redirect()->route("admin.user.index");
    }

    public function editPassword(){
        $id = \Auth::user()->id;
        $user = User::find($id);
        return view("user.edit_password", compact("user"));
    }

    public function updatePassword(Request $request){
        $this->validate($request, [
            "current-password" => [
                "required",
                function ($attribute, $value, $fail){
                    if (!\Hash::check($value, \Auth::user()->password)){
                        return $fail("現在のパスワードを正しく入力してください");
                    }
                }
            ],
            "password" => ["required", "string", "min:8", "confirmed","different:current-password"],
        ]);

        $user = \Auth::user();
        $user->password = \Hash::make($request->input("password"));
        if($user->save()){
            $request->session()->flash("success",__("パスワードを更新しました"));
        }else{
            $request->session()->flash("error",__("パスワードを更新に失敗しました"));
        }

        return redirect()->route("admin.user.edit");
    }
}
