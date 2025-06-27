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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('userName')->unique();
            $table->foreignId('companyId')->nullable()->constrained('companies')->onDelete('cascade');
            $table->string('email')->unique();
            $table->string('empPhoto')->nullable();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->unsignedTinyInteger('role')->default(2)->comment('1=ADMIN, 2=EMPLOYEE');
            $table->enum('status', ['Active', 'Blocked'])->default('Active');
            $table->rememberToken();
            $table->timestamp('createdAt')->useCurrent();
            $table->timestamp('updatedAt')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
