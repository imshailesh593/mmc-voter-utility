<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Voter extends Model
{
    protected $fillable = [
        'name',
        'branch',
        'phone',
        'registration_number',
        'serial_number',
        'electoral_number',
        'degree',
        'address',
    ];

    public static function search(string $phone = '', string $name = '', string $registration = ''): Builder
    {
        $query = static::query();

        if (!empty($phone)) {
            $query->where('phone', 'like', '%' . $phone . '%');
        }

        if (!empty($name)) {
            foreach (explode(' ', trim($name)) as $keyword) {
                if ($keyword !== '') {
                    $query->where('name', 'like', '%' . $keyword . '%');
                }
            }
        }

        if (!empty($registration)) {
            $query->where('registration_number', $registration);
        }

        return $query->orderBy('name');
    }
}
