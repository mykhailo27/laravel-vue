<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class UserViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('User/Index', [
            'users' => User::paginate(10)
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function details(User $user): Response
    {
        return Inertia::render('User/Details', [
            'user' => $user
        ]);
    }
}
