<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posps', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('name');
            $table->string('department');
            $table->string('designation');
            $table->string('employee_code')->unique();
            $table->string('mobile_no')->unique();
            $table->string('email')->unique();
            $table->foreignId('branch_id')->constrained(); // Assumes a 'branches' table exists
            $table->foreignId('reporting_manager')->nullable()->constrained('employees'); // Reference the 'employees' table
            $table->foreignId('relationship_manager')->nullable()->constrained('employees'); // Reference the 'employees' table
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade'); // Add role_id referencing the 'roles' table
            $table->string('level');
            $table->string('grade');
            $table->boolean('is_bqp');
            $table->timestamp('joining_date');
            $table->boolean('active')->default(true);
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posps');
    }
};
