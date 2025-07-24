<?php

use App\Enums\AgeStatus;
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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email')->unique();
            $table->integer('age');
            $table->enum('ageStatus', array_column(AgeStatus::cases(), 'value'))->nullable();
            $table->string('phoneNumber');
            $table->text('bio')->nullable();
            $table->dateTime('dob')->nullable();
            $table->enum('gender', ['Male','Female']);
            $table->string('picture')->nullable();
            $table->timestamp('createdAt')->nullable()->useCurrent();
            $table->timestamp('updatedAt')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
