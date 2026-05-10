<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('organizer')->after('title')->nullable();
            $table->text('location_detail')->after('location')->nullable();
            $table->text('guest_star')->after('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['organizer', 'location_detail', 'guest_star']);
        });
    }
};