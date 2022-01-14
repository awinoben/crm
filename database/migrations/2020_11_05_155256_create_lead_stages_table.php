<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_stages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('stage_id');
            $table->uuid('lead_id');
            $table->jsonb('keywords')->nullable();
            $table->jsonb('products_and_services')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('level');
            $table->boolean('is_complete')->default(false);
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
        Schema::dropIfExists('lead_stages');
    }
}
