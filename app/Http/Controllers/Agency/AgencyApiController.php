<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\User;
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
            'success' => $added
        ]);
    }
}
