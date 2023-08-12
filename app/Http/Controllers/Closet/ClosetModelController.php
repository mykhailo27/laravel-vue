<?php

namespace App\Http\Controllers\Closet;

use App\Http\Controllers\Controller;
use App\Models\Closet;
use App\Models\User;

class ClosetModelController extends Controller
{
    /**
     * @param mixed $ids
     * @note param could be single id or ids
     * @return int
     */
    public static function delete(mixed $ids): int
    {
        return Closet::destroy($ids);
    }

    public static function getById(string $id): Closet
    {
        return Closet::find($id);
    }

    public static function addUser(Closet $closet, User $user): bool
    {
        $closet->users()->syncWithoutDetaching($user);

        return self::hasUser($closet, $user);
    }

    public static function hasUser(Closet $closet, User $user): bool
    {
        return $closet->users()
            ->wherePivot('user_id', '=', $user->id)
            ->exists();
    }

    public static function removeUser(Closet $closet, User $user): bool
    {
        return $closet->users()
            ->detach($user->id);
    }

    public static function nonClosetUser(Closet $closet)
    {
        $users_id = $closet->users()
            ->pluck('user_id')
            ->toArray();

        return User::whereNotIn('id', $users_id)->get();
    }

    public static function create(array $attributes)
    {
        return Closet::create($attributes);
    }

    public static function activate(User $user, Closet $closet): int
    {
        return $user->closets()
            ->updateExistingPivot($closet->id, ['active' => true]);
    }

    public static function deactivateAll(User $user): int
    {
        return $user->closets()
            ->wherePivot('active', '=', true)
            ->update(['closet_user.active' => false]);
    }
}
