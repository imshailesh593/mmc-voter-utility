<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchVenue extends Model
{
    protected $fillable = ['branch', 'venue'];

    public static function forBranch(?string $branch): ?string
    {
        if (!$branch) return null;
        return static::where('branch', $branch)->value('venue');
    }
}
