<?php

namespace Tests\Feature;

use App\Company;
use App\Employee;
use App\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $company;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->company = factory(Company::class)->create();
    }

    /** @test */
    public function a_list_of_employees_can_be_fetched()
    {
        factory(Employee::class, 10)->create(['company_id' => 1]);
        $response = $this->get('/api/employees?api_token=' . $this->user->api_token);
        $response->assertJsonCount(10);
    }

    /** @test */
    public function an_unauthenticated_user_should_be_redirected_to_login()
    {
        $response = $this->post('/api/employees',
            array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, Employee::all());
    }

    /** @test */
    public function an_authenticated_user_can_add_a_employee()
    {
        $response = $this->post('/api/employees', $this->data());

        $employee = Employee::first();

        $this->assertEquals('EmployeeFirstName', $employee->first_name);
        $this->assertEquals('EmployeeLastName', $employee->last_name);
        $this->assertEquals(1, $employee->company_id);
        $this->assertEquals('employee@mail.com', $employee->email);
        $this->assertEquals('999-999-999', $employee->phone);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'employee_id' => $employee->id
            ],
            'links' => [
                'self' => $employee->path()
            ]
        ]);
    }

    /** @test */
    public function email_must_be_a_valid_email()
    {
        $response = $this->post('/api/employees',
            array_merge($this->data(), ['email' => 'NOT EMAIL']));

        $response->assertSessionHasErrors('email');
        $this->assertCount(0, Employee::all());
    }

    /** @test */
    public function a_employee_can_be_retrieved()
    {
        $employee = factory(Employee::class)->create(['company_id' => $this->company->id]);
        $response = $this->get('/api/employees/' . $employee->id . '?api_token=' . $this->user->api_token);

        $response->assertJson([
            'data' => [
                'employee_id' => $employee->id,
                'company_id' => $employee->company_id,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'company' => $this->company->name,
                'email' => $employee->email,
                'phone' => $employee->phone
            ]
        ]);
    }

    /** @test */
    public function a_employee_can_be_patched()
    {
        $employee = factory(Employee::class)->create(['company_id' => $this->company->id]);

        $response = $this->patch('/api/employees/' . $employee->id, $this->data());

        $employee = $employee->fresh();

        $this->assertEquals('EmployeeFirstName', $employee->first_name);
        $this->assertEquals('EmployeeLastName', $employee->last_name);
        $this->assertEquals(1, $employee->company_id);
        $this->assertEquals('employee@mail.com', $employee->email);
        $this->assertEquals('999-999-999', $employee->phone);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'employee_id' => $employee->id
            ],
            'links' => [
                'self' => $employee->path()
            ]
        ]);
    }

    /** @test */
    public function only_admin_can_patch_the_employee()
    {
        $employee = factory(Employee::class)->create(['company_id' => $this->company->id]);

        $anotherUser = factory(User::class)->create(['is_admin' => false]);

        $response = $this->patch('/api/employees/' . $employee->id,
            array_merge($this->data(), ['api_token' => $anotherUser->api_token]));

        $response->assertStatus(403);
    }

    /** @test */
    public function a_employee_can_be_deleted()
    {
        $employee = factory(Employee::class)->create(['company_id' => $this->company->id]);

        $response = $this->delete('/api/employees/' . $employee->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, Employee::all());

        $response->assertStatus(Response::HTTP_NO_CONTENT);

    }

    /** @test */
    public function only_admin_can_delete_the_company()
    {
        $employee = factory(Employee::class)->create(['company_id' => $this->company->id]);

        $anotherUser = factory(User::class)->create(['is_admin' => false]);

        $response = $this->delete('/api/employees/' . $employee->id, ['api_token' => $anotherUser->api_token]);

        $response->assertStatus(403);

    }

    private function data()
    {
        return [
            'first_name' => 'EmployeeFirstName',
            'last_name' => 'EmployeeLastName',
            'company_id' => 1,
            'email' => 'employee@mail.com',
            'phone' => '999-999-999',
            'api_token' => $this->user->api_token
        ];
    }
}
