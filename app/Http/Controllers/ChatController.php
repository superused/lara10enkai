<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chats;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;

class ChatController extends Controller
{
    public function talk($id)
    {
        //今のログインuserがイベントに参加しているかの認証
        $eventusers = DB::table("event_users")->select(
            "event_users.id",
            "event_users.user_id",
            "users.name",
            "event_users.created_at",
        )
            ->join("users", "users.id", "=", "event_users.user_id")
            ->where("event_users.event_id", "=", $id)->get();

        $participants = [];
        foreach ($eventusers as $num => $eventuser) {
            $participants += [$num => $eventuser->user_id];
        }
        ///////参加していなかったら一覧へ戻る
        if (!in_array(\Auth::user()->id, $participants)) {
            return redirect("admin.event.show", $id);
        }
        ///////参加していたらDBからチャットのデータを引っ張ってくる
        else {
            $event = Event::find($id);
            $chats = DB::table("chats")->select(
                "chats.user_id",
                "chats.event_id",
                "users.name",
                "chats.body",
                "chats.updated_at"
            )->join("users", "users.id", "=", "chats.user_id")
            ->where("chats.event_id", "=", $id)->orderBy("chats.updated_at","asc")->get();
            return view("chat.talk", compact("chats","event"));
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, Chats::$rules);
        $chat = new Chats([
            "event_id" => $request->input("event_id"),
            "user_id" => $request->input("user_id"),
            "body" => $request->input("body"),
        ]);
        if ($chat->save()) {
            $request->session()->flash("success", __("投稿しました"));
        } else {
            $request->session()->flash("error", __("投稿に失敗しました。"));
        }
        return redirect()->route("admin.chat.talk",$request->input("event_id"));
    }
}
