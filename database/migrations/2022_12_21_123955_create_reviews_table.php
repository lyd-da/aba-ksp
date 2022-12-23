<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('file_id')->unsigned();
            $table->unsignedBigInteger('reviewed_by');
            $table->string('status')->default('visible');
            $table->string('comment')->nullable();
            $table->integer('rate_count');
            $table->boolean('deleted')->default(0);
            $table->unsignedBigInteger('deleted_by')->nullable();
            // $table->timestamp('deleted_at')->nullable();
            $table->softDeletes();

            $table->timestamps();

            $table->foreign('file_id')->references('id')->on('files')
            ->onDelete('cascade');
            $table->foreign('reviewed_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
