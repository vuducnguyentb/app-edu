<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('file_id')->unsigned()->nullable();
            $table->integer('position')->default(0);
            $table->integer('type')->default(1)->comment('Loại slide.');
            $table->bigInteger('created_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('file_id', 'fk_portal_file')
                ->references('id')->on('files');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('slides');
    }
}
