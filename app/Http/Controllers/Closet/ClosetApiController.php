<?php

namespace App\Http\Controllers\Closet;

use App\Constants\Ability;
use App\Http\Controllers\Controller;
use App\Models\Closet;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClosetApiController extends Controller
{
    public function addUser(Closet $Closet, User $user): Response
    {
        $added = ClosetModelController::addUser($Closet, $user);

        return response([
            'message' => $added
                ? 'User has been added successful'
                : 'Fail to add user to an Closet',
            'success' => $added,
            'user' => $user
        ]);
    }

    public function deleteMultiple(Request $request): Response
    {
        try {
            $this->authorize(Ability::DELETE_ANY, Closet::class);

            $ids = $request->get('ids');
            $deleted = ClosetModelController::delete($ids);
            $success = $deleted === count($ids);

            return response([
                'success' => $success,
                'message' => $success ? 'All closets deleted' : 'Some closets deleted',
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
            $Closet = ClosetModelController::getById($request->get('id'));

            $this->authorize(Ability::DELETE, $Closet);

            $deleted = ClosetModelController::delete($Closet->id);
            return response([
                'success' => $deleted,
                'message' => $deleted ? 'Closet deleted' : 'Closet fail to be deleted',
            ]);
        } catch (AuthorizationException $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function users(Closet $Closet): Response
    {
        return response([
            'success' => true,
            'message' => 'Load Closet users',
            'users' => $Closet->users // todo return a resource
        ]);
    }

    public function removeUser(Closet $Closet, User $user): Response
    {
        $removed = ClosetModelController::removeUser($Closet, $user);

        return response([
            'message' => $removed
                ? 'User has been removed successful'
                : 'Fail to remove user from an Closet',
            'success' => $removed,
            'user' => $user
        ]);
    }
}
