<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Event extends Model
{
    use HasFactory;
    use Sortable;
    use SoftDeletes;

    protected $guarded = [
        "id",
    ];

    protected $sortable = [
        "id",
        "name",
        "detail",
        "max_participant",
        "category_id",
        "user_id",
        "created_at",
        "updated_at",
        "deleted_at",
    ];
    
    public static $rules = [
        "name" => "required",
    ];

    public function orders()
    {
        return $this->hasOne(Category::class, "id");
    }
}
