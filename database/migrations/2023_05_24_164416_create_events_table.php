<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments("id")->unique()->comment("ID");
            $table->string("name",255)->comment("イベント名");
            $table->string("detail",255)->comment("詳細");
            $table->integer("max_paticipant")->comment("最大参加者");
            $table->integer("category_id")->comment("カテゴリID");
            $table->integer("user_id")->comment("ユーザID");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
