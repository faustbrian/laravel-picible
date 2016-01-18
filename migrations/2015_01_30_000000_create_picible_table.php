<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePicibleTable extends Migration
{
    public function up()
    {
        Schema::create('picible_picture', function (Blueprint $table) {
            $table->increments('id')->unsigned();

            $table->integer('picible_id')->unsigned()->nullable();
            $table->string('picible_type')->nullable();

            $table->string('slot')->nullable();

            $table->integer('width')->unsigned();
            $table->integer('height')->unsigned();

            $table->string('mime_type');
            $table->string('extension');
            $table->string('orientation');

            $table->timestamps();

            // Indexes
            $table->unique(['picible_id', 'picible_type', 'slot'], 'U_picible_slot');
        });
    }

    public function down()
    {
        Schema::drop('picible_picture');
    }
}
