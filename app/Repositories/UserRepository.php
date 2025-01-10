<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserRepository extends BaseRepository
{
    public $model;

    function __construct(User $model)
    {
        $this->model = $model;
    }

    public function authByUserId($id)
    {
        return Auth::loginUsingId($id);
    }
}
