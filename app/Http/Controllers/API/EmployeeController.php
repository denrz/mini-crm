<?php

namespace App\Http\Controllers\API;

use App\Employee;
use App\Http\Resources\Employee as EmployeeResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\EmployeeStoreRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the employees.
     *
     * @throws AuthorizationException
     * @return Response
     */
    public function index()
    {
        $this->authorize('viewAny', Employee::class);
        return response(EmployeeResource::collection(Employee::all()));
    }

    /**
     * Store a newly created employee in storage.
     *
     * @param \App\Http\Requests\EmployeeStoreRequest $request
     *
     * @throws AuthorizationException
     * @return Response
     */
    public function store(EmployeeStoreRequest $request)
    {
        $this->authorize('create', Employee::class);
        $employee = Employee::create($request->validated());

        return (new EmployeeResource($employee))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified employee.
     *
     * @param \App\Employee employees
     *
     * @throws AuthorizationException
     * @return \App\Http\Resources\Employee
     */
    public function show(Employee $employee)
    {
        $this->authorize('view', $employee);

        return new EmployeeResource($employee);
    }

    /**
     * Update the specified employee in storage.
     *
     * @param \App\Http\Requests\EmployeeStoreRequest $request
     * @param \App\Employee  $employee
     *
     * @throws AuthorizationException
     * @throws ModelNotFoundException
     * @return Response
     */
    public function update(EmployeeStoreRequest $request, Employee $employee)
    {
        $this->authorize('update', $employee);
        $employee->update($request->validated());

        return (new EmployeeResource($employee))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified employee from storage.
     *
     * @param \App\Employee $employee
     *
     * @throws AuthorizationException
     * @throws ModelNotFoundException
     * @return Response
     */
    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);
        $employee->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }
}
