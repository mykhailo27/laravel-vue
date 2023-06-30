<?php

namespace App\Http\Controllers\Company;

use App\Constants\Ability;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyApiController extends Controller
{
    public function addUser(Company $Company, User $user): Response
    {
        $added = CompanyModelController::addUser($Company, $user);

        return response([
            'message' => $added
                ? 'User has been added successful'
                : 'Fail to add user to an Company',
            'success' => $added,
            'user' => $user
        ]);
    }

    public function deleteMultiple(Request $request): Response
    {
        try {
            $this->authorize(Ability::DELETE_ANY, Company::class);

            $ids = $request->get('ids');
            $deleted = CompanyModelController::delete($ids);
            $success = $deleted === count($ids);

            return response([
                'success' => $success,
                'message' => $success ? 'All companies deleted' : 'Some companies deleted',
            ]);
        } catch (AuthorizationException $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function delete(Request $request): Response
    {
        try {
            $company = CompanyModelController::getById($request->get('id'));

            $this->authorize(Ability::DELETE, $company);

            $deleted = CompanyModelController::delete($company->id);
            return response([
                'success' => $deleted,
                'message' => $deleted ? 'Company deleted' : 'Company fail to be deleted',
            ]);
        } catch (AuthorizationException $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function users(Company $company): Response
    {
        return response([
            'success' => true,
            'message' => 'Load Company users',
            'users' => $company->users // todo return a resource
        ]);
    }

    public function removeUser(Company $company, User $user): Response
    {
        $removed = CompanyModelController::removeUser($company, $user);

        return response([
            'message' => $removed
                ? 'User has been removed successful'
                : 'Fail to remove user from an company',
            'success' => $removed,
            'user' => $user
        ]);
    }
}
