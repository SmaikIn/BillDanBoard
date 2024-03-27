<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        return CompanyResource::collection(Company::all());
    }

    public function store(CreateCompanyRequest $request)
    {
        return new CompanyResource(Company::create($request->validated()));
    }

    public function show(Company $company)
    {
        return new CompanyResource($company);
    }

    public function update(CreateCompanyRequest $request, Company $company)
    {
        $company->update($request->validated());

        return new CompanyResource($company);
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json();
    }
}
