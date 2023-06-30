<?php

namespace App\Http\Controllers\Agency;

use App\Constants\Ability;
use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AgencyApiController extends Controller
{
    public function addUser(Agency $agency, User $user): Response
    {
        $added = $agency->addUser($user);

        return response([
            'message' => $added
                ? 'User has been added successful'
                : 'Fail to add user to an agency',
            'success' => $added,
            'user' => $user
        ]);
    }

    public function deleteMultiple(Request $request): Response
    {
        try {
            $this->authorize(Ability::DELETE_ANY, Agency::class);

            $ids = $request->get('ids');
            $deleted = AgencyModelController::delete($ids);
            $success = $deleted === count($ids);

            return response([
                'success' => $success,
                'message' => $success ? 'All agencies deleted' : 'Some agencies deleted',
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
            $agency = AgencyModelController::getById($request->get('id'));

            $this->authorize(Ability::DELETE, $agency);

            $deleted = AgencyModelController::delete($agency->id);
            return response([
                'success' => $deleted,
                'message' => $deleted ? 'Agency deleted' : 'Agency fail to be deleted',
            ]);
        } catch (AuthorizationException $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function users(Agency $agency): Response
    {
        return response([
            'success' => true,
            'message' => 'Load agency users',
            'users' => $agency->users
        ]);
    }

    public function removeUser(Agency $agency, User $user): Response
    {
        $removed = $agency->removeUser($user);

        return response([
            'message' => $removed
                ? 'User has been removed successful'
                : 'Fail to remove user from an agency',
            'success' => $removed,
            'user' => $user
        ]);
    }
}
