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
        "events.updated_at",
        "events.deleted_at"
    )
    ->join("categories","events.category_id", "=", "categories.id")
    ->join("users","events.user_id", "=", "users.id")
        ->leftjoinSub($counts, "event_users", function (JoinClause $join) {
            $join->on("events.id", "=", "event_users.event_id");
            //ここはプリペアードステートメントを作らないと本来はいけない。
        })->whereNull("events.deleted_at")->simplePaginate(5);
        return view("event.index", compact("events"));
    }

    public function mylist()
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
            "events.updated_at",
            "events.deleted_at",            
        )
        ->join("categories","events.category_id", "=", "categories.id")
        ->join("users","events.user_id", "=", "users.id")
            ->leftjoinSub($counts, "event_users", function (JoinClause $join) {
                $join->on("events.id", "=", "event_users.event_id");
                //ここはプリペアードステートメントを作らないと本来はいけない。
            })
            ->where("events.user_id","=",$userid )
            ->whereNull("events.deleted_at")            
            ->simplePaginate(5);

        return view("event.mylist", compact("events"));
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
        return redirect()->route("admin.event.mylist");
    }

    public function edit($id){
        $event = Event::find($id);
        $categories = Category::all();
        $users = User::all();
        return view("event.edit", compact("event","categories", "users"));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, Event::$rules);

        $event = Event::find($id);
        $event->name = $request->input("name");
        $event->detail = $request->input("detail");
        $event->max_participant = $request->input("max_participant");
        $event->category_id = $request->input("category_id");
        $event->user_id = $request->input("user_id");

        if($event->save()){
            $request->session()->flash("success",__("イベントを更新しました"));
        }else{
            $request->session()->flash("error",__("イベントの更新に失敗しました。"));
        }

        return redirect()->route("admin.event.mylist");
    }

    public function show($id){

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
        "events.updated_at",
    )
    ->join("categories","events.category_id", "=", "categories.id")
    ->join("users","events.user_id", "=", "users.id")
        ->leftjoinSub($counts, "event_users", function (JoinClause $join) {
            $join->on("events.id", "=", "event_users.event_id");
            //ここはプリペアードステートメントを作らないと本来はいけない。
        })->where("events.id", "=", $id)->get();

        $eventusers = DB::table("event_users")->select(
            "event_users.id",
            "event_users.user_id",
            "users.name",
            "event_users.created_at",
            "event_users.deleted_at",            
            )
        ->join("users","users.id", "=", "event_users.user_id")
        ->where("event_users.event_id", "=", $id)->get();

        $currentevent = Event::find($id);
        $currentuser = \Auth::user()->id;

        $participants = [];
        foreach($eventusers as $id => $eventuser){
            if(!isset($eventuser->deleted_at)){
                $participants += [$id => $eventuser->user_id]; 
            }
        }
        // var_dump($participants);
        return view("event.show", compact("events","eventusers","currentuser","currentevent","participants"));
    }

    public function delete($id)
    {
        Event::destroy($id);
        return redirect()->route("admin.event.mylist");
    }
}
