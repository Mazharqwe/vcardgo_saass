<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('slug')->nullable();
            $table->text('title')->nullable();
            $table->string('password')->nullable();
            $table->string('enable_password')->nullable();
            $table->string('designation')->nullable();
            $table->text('sub_title')->nullable();
            $table->text('description')->nullable();
            $table->text('banner')->nullable();
            $table->text('logo')->nullable();
            $table->text('card_theme')->nullable();
            $table->string('theme_color')->nullable();
            $table->text('links')->nullable();
            $table->string('status')->default('active');
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_image')->nullable();
            $table->string('enable_businesslink')->nullable();
            $table->string('enable_subdomain')->nullable();
            $table->string('subdomain')->nullable();
            $table->string('enable_domain')->default('off');
            $table->string('domains')->nullable();
            $table->string('google_analytic')->nullable();
            $table->string('fbpixel_code')->nullable();
            $table->text('customjs')->nullable();
            $table->string('customcss')->nullable();
            $table->string('is_custom_html_enabled')->nullable();
            $table->text('custom_html_text')->nullable();
            $table->string('is_gdpr_enabled')->nullable();
            $table->text('gdpr_text')->nullable();
            $table->string('is_branding_enabled',255)->nullable();
            $table->string('branding_text')->nullable();
            $table->string('google_fonts')->nullable();
            $table->string('enable_pwa_business')->default('off');
            $table->string('admin_enable')->default('on');
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('businesses');
    }
}
