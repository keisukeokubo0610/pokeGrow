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
        Schema::create('arranges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poke_id')->constrained('pokemons')->onDelete('cascade');;

            $table->string('title'); //タイトル
            $table->string('ability'); //特性
            $table->string('nature'); //性格
            $table->string('held_item'); //持ち物
            //* 技
            $table->string('move1')->nullable();
            $table->string('move2')->nullable();
            $table->string('move3')->nullable();
            $table->string('move4')->nullable();
            //* 努力値
            $table->integer('effort_hp')->default(0);
            $table->integer('effort_attack')->default(0);
            $table->integer('effort_defense')->default(0);
            $table->integer('effort_special_attack')->default(0);
            $table->integer('effort_special_defense')->default(0);
            $table->integer('effort_speed')->default(0);
            $table->text('note')->nullable(); //メモ
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arranges');
    }
};
