<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvisoiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provisoires', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->constrained('users', 'id');
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->boolean('popular')->nullable();
            $table->integer('price')->nullable();
            $table->text('description')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();
            $table->json('cat')->nullable();
            $table->string('img1')->nullable();
            $table->string('img2')->nullable();
            $table->string('img3')->nullable();
            $table->string('img4')->nullable();
            $table->string('img5')->nullable();
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
        Schema::dropIfExists('provisoires');
    }
}
