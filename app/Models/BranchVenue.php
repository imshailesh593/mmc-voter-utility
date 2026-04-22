<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchVenue extends Model
{
    protected $fillable = ['branch', 'venue'];

    public static function forBranch(?string $branch): ?string
    {
        if (!$branch) return null;
        return static::whereRaw('LOWER(TRIM(branch)) = ?', [strtolower(trim($branch))])->value('venue');
    }

    public static function allKeyed(): array
    {
        return static::all()->keyBy(fn($v) => strtolower(trim($v->branch)))->map->venue->toArray();
    }
}
