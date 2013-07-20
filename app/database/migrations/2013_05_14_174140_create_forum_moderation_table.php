<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForumModerationTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_moderation', function(Blueprint $table) {
            $table->increments('id');
            $table->string('resourceType')->index();
            $table->string('resourceId', 11)->index();
            $table->string('user_id', 10)->index();
            $table->text('reason');
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
        Schema::drop('forum_moderation');
    }

}