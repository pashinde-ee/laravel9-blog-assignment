<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type', 50)->comment('Model class information.');
            $table->integer('entity_id')->comment('Id of the model in its own table.');
            $table->string('file_original_name', 50)->comment('Name of the uploaded file.');
            $table->string('file_location', 100)
                ->comment('Information regarding the location of the folder the file is kept in the s3 bucket.');
            $table->string('size', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
