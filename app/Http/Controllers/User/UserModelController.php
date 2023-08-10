<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

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

}
