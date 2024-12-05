<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail; // Add this
use Spatie\Permission\Traits\HasRoles; // Import HasRoles trait
class Posp extends Model
{
    use HasFactory,HasApiTokens,HasRoles;


    protected $fillable = [
        'title', 'name', 'mobile_no', 'email', 'level_and_grade', 'branch_id',
        'reporting_manager_id', 'relationship_manager_id', 'bqp_id', 'role_id', 'exam_duration',
        'street', 'city', 'state', 'pincode', 'email_verified', 'date_of_birth', 'education',
        'login_password', 'posp_code', 'active', 'aadharcard_number', 'pancard_number',
        'marksheet_pdf', 'aadharcard_pdf', 'pancard_pdf', 'documentation_verification_date',
    ];

    
    protected $dates = ['joining_date'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function reportingManager()
    {
        return $this->belongsTo(Employee::class, 'reporting_manager_id');
    }

    public function relationshipManager()
    {
        return $this->belongsTo(Employee::class, 'relationship_manager_id');
    }

    public function bqp()
    {
        return $this->belongsTo(Employee::class, 'bqp_id');
    }


        // Set the guard name for token authentication
        protected $guard_name = 'sanctum'; // Ensure this is set for API-based token authentication

}
