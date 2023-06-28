<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\User;
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
        if (is_array($ids = $request->get('ids'))) {
            $deleted = AgencyModelController::deleteByIds($ids);

            $success = $deleted === count($ids);

            return response([
                'success' => $success,
                'message' => $success ? 'Multiple agencies deleted' : 'Only some of the agencies deleted',
            ]);
        }

        return response([
            'success' => false,
            'message' => 'No ids found, so no agency is deleted',
        ]);
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
