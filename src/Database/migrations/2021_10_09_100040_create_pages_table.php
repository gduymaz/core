<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('structure_id')->index();
            $table->foreignId('container_id')->index()->constrained()->onDelete('cascade');
            $table->tinyInteger('status')->default(2);
            $table->unsignedInteger('order')->default(1);
            $table->date('date')->nullable();
            $table->string('cvar_1')->nullable();
            $table->string('cvar_2')->nullable();
            $table->string('cvar_3')->nullable();
            $table->integer('cint_1')->nullable();
            $table->integer('cint_2')->nullable();
            $table->integer('cint_3')->nullable();
            $table->text('ctext_1')->nullable();
            $table->text('ctext_2')->nullable();
            $table->date('cdate_1')->nullable();
            $table->date('cdate_2')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
