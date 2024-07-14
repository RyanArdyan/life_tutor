<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // create tutorial table
        Schema::create('tutorial', function (Blueprint $table) {
            // create big integer data type that auto increment and primary key
            $table->bigIncrements('tutorial_id');
            // foreign key, the relationship is 1 tutorial belongs to 1 user and 1 user has many tutorials
            $table->foreignId('user_id')->constrained('users')
                // the reference is the user_id column in the user table
                ->references('user_id')
                ->onUpdate('cascade')
                // so if i delete the user then all then related tutorials will be delete4
                ->onDelete('cascade');
            $table->string('name');
            // for example 7 meetings
            $table->smallInteger('number_of_meetings');
            // for example 1 hundred thousand
            $table->integer('price');
            $table->date('date');
            $table->time('time');
            $table->string('place');
            $table->text('description');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutorial');
    }
};
