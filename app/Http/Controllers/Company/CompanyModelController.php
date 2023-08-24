<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Closet\ClosetModelController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserModelController;
use App\Models\Company;
use App\Models\User;
use App\Models\Warehouse;

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

    public static function createGeneralCloset(Company $company, Warehouse $warehouse)
    {
        $attributes = [
            'name' => 'general',
            'company_id' => $company->id,
            'warehouse_id' => $warehouse->id
        ];

        return ClosetModelController::create($attributes);
    }

    public static function unSelectAll(User $user): int
    {
        return $user->companies()
            ->wherePivot('selected', '=', true)
            ->update([
                'selected' => false
            ]);
    }

    public static function select(User $user, Company $company): int
    {
        $selected = $user->companies()
            ->updateExistingPivot($company->id, [
                'selected' => true
            ]);

        if ($selected) {
            $closet = $company->generalCloset(); // todo only activate if there is no other active closet
            ClosetModelController::addUser($closet, $user);
            ClosetModelController::activate($user, $closet);
        }

        return $selected;
    }

    public static function RandomFirst(): ?Company
    {
        return Company::inRandomOrder()->first();
    }
}
