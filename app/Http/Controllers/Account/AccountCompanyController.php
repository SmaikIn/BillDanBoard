<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class AccountCompanyController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function index()
    {
        
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
