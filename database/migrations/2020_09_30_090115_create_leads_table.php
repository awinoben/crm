<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('country_id');
            $table->uuid('sale_funnel_id');
            $table->uuid('company_id');
            $table->uuid('lead_type_id');
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->unique()->nullable();
            $table->tinyInteger('age')->default(0);
            $table->string('gender')->nullable();
            $table->string('location')->nullable();
            $table->string('professional')->nullable();
            $table->jsonb('social_media')->nullable();
            $table->jsonb('globe')->nullable();
            $table->smallInteger('score')->default(0);
            $table->boolean('is_lead')->default(true);
            $table->boolean('is_contact')->default(false);
            $table->boolean('is_customer')->default(false);
            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists('leads');
    }
}
