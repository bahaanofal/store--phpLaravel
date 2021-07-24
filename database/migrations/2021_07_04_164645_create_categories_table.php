<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            // id bigint unsigned auto_increment primary
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('parent_id')->nullable()->constrained('categories', 'id')->nullOnDelete();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->enum('status', ['active', 'draft']);
            // لاختيار قيمة من قائمة خيارات

            // طريقة أخرى لعمل مفتاح أجنبي
            // $table->unsignedBigInteger('parent_id');
            // $table->foreign('parent_id')->references('id')->on('categories')->cascadeOnDelete();
            
            // created_at and updated_at
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
        Schema::dropIfExists('categories');
    }
}
