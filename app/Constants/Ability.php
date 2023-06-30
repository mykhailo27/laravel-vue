<?php

namespace App\Constants;

class Ability extends Constant
{
    public const VIEW_ANY = 'viewAny';
    public const VIEW = 'view';
    public const CREATE = 'create';
    public const UPDATE = 'update';
    public const DELETE = 'delete';
    public const RESTORE = 'restore';
    public const FORCE_DELETE = 'forceDelete';
    public const DELETE_ANY = 'deleteAny';
}
