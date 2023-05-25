<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $homeMenus = [];
        $homeMenus["イベント一覧"] = route("admin.event.index");
        $homeMenus["イベント新規登録"] = route("admin.event.create");
        $homeMenus["カテゴリ一覧"] = route("admin.category.index");
        $homeMenus["カテゴリ新規登録"] = route("admin.category.create");

        $events = Event::with(["Category","User"])->sortable()->simplePaginate(5);
        return view('home', compact("homeMenus","events"));
    }
}
