<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $counts = DB::table("event_users")->select("event_id", DB::raw("COUNT(event_id) as count"))
        ->groupBy("event_id")->whereNull("event_users.deleted_at");
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
        })->whereNull("events.deleted_at")->simplePaginate(5);

        return view("index", compact("events"));
    }

    public function show($id){

        $counts = DB::table("event_users")->select("event_id", DB::raw("COUNT(event_id) as count"))
        ->groupBy("event_id")->whereNull("event_users.deleted_at");
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
        })->where("events.id", "=", $id)
        ->whereNull("events.deleted_at")->get();

        return view("show", compact("events"));
    }

}
