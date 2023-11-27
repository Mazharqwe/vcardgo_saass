<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',100)->unique();
            $table->float('price',15,2)->default(0);
            $table->string('duration',100);
            $table->string('themes')->nullable();
            $table->integer('business')->default(0);
            $table->integer('max_users')->default(0);
            $table->text('description')->nullable();
            $table->string('enable_custdomain')->default('off');
            $table->string('enable_custsubdomain')->default('off');
            $table->string('enable_branding',255)->default('on');
            $table->string('pwa_business')->default('off');
            $table->string('enable_qr_code',255)->default('on');
            $table->string('enable_chatgpt',255)->default('on');
            $table->float('storage_limit',255)->default('0.00');
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
        Schema::dropIfExists('plans');
    }
}
