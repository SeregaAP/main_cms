<?php
// app/Models/Role.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles'; // ← исправлено на 'roles'

    protected $fillable = ['name', 'slug', 'permissions', 'description', 'is_system'];
    
    protected $casts = [
        'permissions' => 'array'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    public function hasPermission($resource, $action = null)
    {
        $permissions = $this->permissions ?? [];
        
        if (isset($permissions['*']) && in_array('*', $permissions['*'])) {
            return true;
        }
        
        if (!isset($permissions[$resource])) {
            return false;
        }
        
        if (in_array('*', $permissions[$resource])) {
            return true;
        }
        
        return $action && in_array($action, $permissions[$resource]);
    }
}