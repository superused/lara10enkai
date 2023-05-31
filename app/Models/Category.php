<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model
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
        "created_at",
        "update_at",
    ];

    public static $rules = [
        "name" => "required",
    ];

    public function orders(){
        return $this->hasMany(Order::class, "category_id");
    }
}
