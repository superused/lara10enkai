<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Chats extends Model
{
    use HasFactory;
    use Sortable;
    use SoftDeletes;

    protected $guarded = [
        "id",
    ];

    protected $sortable = [
        "id",
        "user_id",
        "event_id",
        "created_at",
        "updated_at",
    ];

    public static $rules = [
        "user_id" => "required",
    ];
}
