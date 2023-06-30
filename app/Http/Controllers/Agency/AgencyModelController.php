<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\User;

class AgencyModelController extends Controller
{
    /**
     * @param mixed $ids
     * @note param could be single id or ids
     * @return int
     */
    public static function delete(mixed $ids): int
    {
        return Agency::destroy($ids);
    }

    public static function getById(string $id): Agency
    {
        return Agency::find($id);
    }

    public static function addUser(Agency $agency, User $user): bool
    {
        $agency->users()->syncWithoutDetaching($user);

        return self::hasUser($agency, $user);
    }

    public static function hasUser(Agency $agency, User $user): bool
    {
        return $agency->users()
            ->wherePivot('user_id', '=', $user->id)
            ->exists();
    }

    public static function nonAgencyUser(Agency $agency)
    {
        $users_id = $agency->users()
            ->pluck('user_id')
            ->toArray();

        return User::whereNotIn('id', $users_id)->get();
    }

    public static function removeUser(Agency $agency, User $user): bool
    {
        return $agency->users()
            ->detach($user->id);
    }
}
