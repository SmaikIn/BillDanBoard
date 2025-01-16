<?php

namespace App\Http\Middleware;

use App\Http\Checker\Checker;
use App\Http\Responses\JsonErrorResponse;
use App\Services\Company\Repositories\CompanyRepository;
use Closure;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class UserCompanyMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        $companyId = Uuid::fromString($request->route('companyId'));

        $checker = resolve(Checker::class);

        $exists = $checker->checkUserCompany($companyId);
        if (!$exists) {
            return new JsonErrorResponse(__('errors.forbidden'), status: Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
