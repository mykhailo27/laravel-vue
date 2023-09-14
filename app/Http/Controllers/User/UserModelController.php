<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Notifications\InvitationToJoinCompany;

class UserModelController extends Controller
{
    public static function delete(mixed $ids): int
    {
        return User::destroy($ids);
    }

    public static function getById(string $id): User
    {
        return User::find($id);
    }

    public static function inviteToJoinCompany(User $user, Company $company): void
    {
        $notification = new InvitationToJoinCompany($company);

        $user->notify($notification);
    }

    public static function getFirstRandom(): ?User
    {
        return User::inRandomOrder()->first();
    }
}
