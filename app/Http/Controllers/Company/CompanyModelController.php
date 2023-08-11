<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserModelController;
use App\Models\Company;
use App\Models\User;

class CompanyModelController extends Controller
{
    /**
     * @param mixed $ids
     * @note param could be single id or ids
     * @return int
     */
    public static function delete(mixed $ids): int
    {
        return Company::destroy($ids);
    }

    public static function getById(string $id): Company
    {
        return Company::find($id);
    }

    public static function addUser(Company $company, User $user): bool
    {
        $company->users()->syncWithoutDetaching($user);

        if (self::hasUser($company, $user)) {
            UserModelController::inviteToJoinCompany($user, $company);

            return true;
        }

        return false;
    }

    public static function hasUser(Company $company, User $user): bool
    {
        return $company->users()
            ->wherePivot('user_id', '=', $user->id)
            ->exists();
    }

    public static function removeUser(Company $company, User $user): bool
    {
        return $company->users()
            ->detach($user->id);
    }

    public static function nonCompanyUser(Company $company)
    {
        $users_id = $company->users()
            ->pluck('user_id')
            ->toArray();

        return User::whereNotIn('id', $users_id)->get();
    }
}
