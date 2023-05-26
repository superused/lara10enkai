<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class EventUsers extends Model
{
    use HasFactory;
    use Sortable;

    protected $guarded = [
        "id",
    ];

    protected $sortable = [
        "id",
        "event_id",
        "user_id",
        "created_at",
        "update_at",
    ];

    public static $rules = [
        "event_id" => "required",
    ];

    public function orders(){
        return $this->hasMany(Order::class, "category_id");
    }
}
