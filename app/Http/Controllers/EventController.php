<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        //subクエリを使用したデータベース解析
        $userid = \Auth::user()->id;

        $counts = DB::table("event_users")->select("event_id", DB::raw("COUNT(event_id) as count"))
            ->groupBy("event_id");
        $events = DB::table("events")->select(
            "events.id",
            "events.name",
            "events.max_participant",
            "categories.name as category_name",
            "event_users.count",
            "events.user_id",
            "users.name as user_name",
            "events.updated_at"
        )
        ->join("categories","events.category_id", "=", "categories.id")
        ->join("users","events.user_id", "=", "users.id")
            ->leftjoinSub($counts, "event_users", function (JoinClause $join) {
                $join->on("events.id", "=", "event_users.event_id");
                //ここはプリペアードステートメントを作らないと本来はいけない。
            })->where("events.user_id","=",$userid)->simplePaginate(5);

        // var_dump($id);
        // exit;
        return view("event.index", compact("events"));
    }

    public function create()
    {
        $categories = Category::all();
        $users = User::all();
        return view("event.create", compact("categories", "users"));
    }

    public function store(Request $request)
    {
        $this->validate($request, Event::$rules);
        $event = new Event([
            "name" => $request->input("name"),
            "detail" => $request->input("detail"),
            "max_participant" => $request->input("max_participant"),
            "category_id" => $request->input("category_id"),
            "user_id" => $request->input("user_id"),
        ]);
        if ($event->save()) {
            $request->session()->flash("success", __("イベントを新規登録しました"));
        } else {
            $request->session()->flash("error", __("イベントの新規登録に失敗しました。"));
        }
        return redirect()->route("admin.event.index");
    }

    public function delete($id)
    {
        Event::destroy($id);
        return redirect()->route("admin.event.index");
    }
}
