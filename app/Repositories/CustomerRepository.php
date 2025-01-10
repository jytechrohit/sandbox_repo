<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomerRepository extends BaseRepository
{
    public $model;

    function __construct(Customer $model)
    {
        $this->model = $model;
    }
    public function getCustomers($limit)
    {
        return $this->model->latest()
            ->paginate($limit)
            ->withQueryString();
    }
}
