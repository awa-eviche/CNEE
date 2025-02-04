<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'model_has_roles', 'role_id', 'model_id');
    }
    public function scopeExceptSuperadmin($query)
    {
        return $query->where('name', '!=', config('constants.roles.superadmin'));
    }
  
    // Scope pour exclure lesentreprise
    public function scopeExceptAdmin($query)
    {
        return $query->where('name', '!=', config('constants.roles.entreprise'));
    }

}
