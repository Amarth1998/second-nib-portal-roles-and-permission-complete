<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles; // Import HasRoles trait
class Posp extends Model
{
    use HasFactory,HasApiTokens,HasRoles;

    protected $fillable = [
        'title',
        'name',
        'department',
        'designation',
        'employee_code',
        'mobile_no',
        'email',
        'branch_id',
        'reporting_manager',
        'relationship_manager',
        'level',
        'grade',
        'is_bqp',
        'joining_date',
        'password',
        'active',
        'role_id'
    ];

    protected $dates = ['joining_date'];

    // Relationship to the Reporting Manager (self-referencing)
    public function reportingManager()
    {
        return $this->belongsTo(User::class, 'reporting_manager');
    }

    // Relationship to the Relationship Manager (self-referencing)
    public function relationshipManager()
    {
        return $this->belongsTo(User::class, 'relationship_manager');
    }

        // Set the guard name for token authentication
        protected $guard_name = 'sanctum'; // Ensure this is set for API-based token authentication

}
