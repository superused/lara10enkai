<?php

namespace App\Http\Controllers;

use App\Models\EventUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventUsersController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, EventUsers::$rules);
        $count = 0;
        //データがあるならdeleted_atを消して回復させる
        $for_delete_user_search = DB::table("event_users")->select("id","event_id", "user_id")->get();
        foreach($for_delete_user_search as $value){
        if (($value->event_id == $request->input("event_id")) && ($value->user_id == $request->input("user_id"))) {
            EventUsers::onlyTrashed()->where('id', $value->id)->restore();
            $request->session()->flash("success", __("イベントに参加しました"));
            //deletedがあったらカウントする。
            $count++;
            return redirect()->route("admin.event.show", $request->input("event_id"));
        }}
        ////データがなかったらデータを格納する
        if($count==0) {
            $eventusers = new EventUsers([
                "event_id" => $request->input("event_id"),
                "user_id" => $request->input("user_id"),
            ]);
        if ($eventusers->save()) {
            $request->session()->flash("success", __("イベントに参加しました"));
        } else {
            $request->session()->flash("error", __("イベントの参加に失敗しました。"));
        }
    }
    return redirect()->route("admin.event.show", $request->input("event_id"));
}

    public function delete(Request $request, $id)
    {
        $this->validate($request, EventUsers::$rules2);
        EventUsers::where('user_id', '=', $request->input("user_id"))->delete();
        $request->session()->flash("delete", __("イベントから辞退しました"));
        return redirect()->route("admin.event.show", $id);
    }
}
