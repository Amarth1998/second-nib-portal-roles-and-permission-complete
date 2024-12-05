<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePospsTable extends Migration
{
    public function up()
    {
        Schema::create('posps', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('name');
            $table->string('mobile_no');
            $table->string('email')->unique();
            $table->string('login_password')->nullable();
            $table->boolean('email_verified')->nullable()->default(false);
            $table->foreignId('role_id')->nullable()->constrained()->onDelete('cascade');

            $table->foreignId('relationship_manager_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->foreignId('reporting_manager_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->foreignId('branch_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('level_and_grade')->nullable();


            $table->foreignId('bqp_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->integer('exam_duration')->nullable()->default(86400); // in seconds
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('education')->nullable();
            $table->string('posp_code')->nullable()->unique();
            $table->boolean('active')->nullable()->default(true);
            $table->string('aadharcard_number')->nullable();
            $table->string('pancard_number')->nullable();
            $table->string('marksheet_pdf')->nullable();
            $table->string('aadharcard_pdf')->nullable();
            $table->string('pancard_pdf')->nullable();
         
            $table->date('documentation_verification_date')->nullable();
            $table->timestamps();  // Uncomment this line to enable timestamps
            // $table->timestamp('joining_date'); // No default value here
            $table->timestamp('joining_date')->useCurrent(); // Set default to current timestamp

          
        });
    }

    public function down()
    {
        Schema::dropIfExists('posps');
    }
}
