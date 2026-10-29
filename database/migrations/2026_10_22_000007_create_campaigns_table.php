<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type')->default('banner'); // banner, sponsored, announcement, interstitial
            $table->string('status')->default('active'); // active, paused, scheduled, completed
            $table->string('badge_text')->nullable();
            $table->string('cta_text')->default('Learn More');
            $table->string('target_url')->default('#');
            $table->text('content')->nullable();
            $table->integer('impressions')->default(0);
            $table->integer('clicks')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
