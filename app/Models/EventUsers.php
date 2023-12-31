<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class EventUsers extends Model
{
    use HasFactory;
    use Sortable;
    use SoftDeletes;

    protected $guarded = [
        "id",
    ];

    protected $sortable = [
        "id",
        "event_id",
        "user_id",
        "created_at",
        "updated_at",
    ];

    public static $rules = [
        "event_id" => "required",
    ];

    public static $rules2 = [
        "user_id" => "required",
    ];

    public function orders(){
        return $this->hasMany(Order::class, "category_id");
    }
}
