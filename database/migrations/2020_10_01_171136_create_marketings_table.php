<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('company_id');
            $table->uuid('campaign_id')->nullable();
            $table->uuid('tool_id');
            $table->string('frequency');
            $table->string('subject');
            $table->longText('description');
            $table->boolean('is_sent')->default(false);
            $table->boolean('is_closed')->default(false);
            $table->timestamp('queued_at')->nullable();
            $table->timestamp('callback_at')->nullable();
            $table->timestamp('schedule_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marketings');
    }
}
