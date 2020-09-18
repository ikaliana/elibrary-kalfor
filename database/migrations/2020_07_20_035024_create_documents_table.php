<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('gallery_id')->unsigned();
            $table->string('name');
            $table->string('filename')->nullable();
            $table->string('fileformat',100)->nullable();
            $table->dateTime('uploaded_date', 0);
            $table->string('description',2000);
            $table->integer('category')->unsigned();
            $table->integer('visibility')->unsigned();
            $table->string('license')->nullable();
            $table->integer('filesize')->unsigned();
            $table->timestamps();
            $table->nullableMorphs('attributes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
