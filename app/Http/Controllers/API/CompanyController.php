<?php

namespace App\Http\Controllers\API;

use App\Company;
use App\Http\Resources\Company as CompanyResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\CompanyStoreRequest;

class CompanyController extends Controller
{
    /**
     * Display a listing of the companies.
     *
     * @throws AuthorizationException
     * @return Response
     */
    public function index()
    {
        $this->authorize('viewAny', Company::class);
        return response(CompanyResource::collection(Company::all()));
    }

    /**
     * Store a newly created company in storage.
     *
     * @param \App\Http\Requests\CompanyStoreRequest $request
     *
     * @throws AuthorizationException
     * @return Response
     */
    public function store(CompanyStoreRequest $request)
    {
        $this->authorize('create', Company::class);
        $company = Company::create($request->validated());

        return (new CompanyResource($company))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified company.
     *
     * @param \App\Company $company
     *
     * @throws AuthorizationException
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        $this->authorize('view', $company);

        return response(new CompanyResource($company));
    }

    /**
     * Update the specified company in storage.
     *
     * @param \App\Http\Requests\CompanyStoreRequest $request
     * @param \App\Company $company
     *
     * @throws AuthorizationException
     * @throws ModelNotFoundException
     * @return Response
     */
    public function update(CompanyStoreRequest $request, Company $company)
    {
        $this->authorize('update', $company);
        $company->update($request->validated());

        return (new CompanyResource($company))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified company from storage.
     *
     * @param \App\Company $company
     *
     * @throws AuthorizationException
     * @throws ModelNotFoundException
     * @return Response
     */
    public function destroy(Company $company)
    {
        $this->authorize('delete', $company);
        $company->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }

}
