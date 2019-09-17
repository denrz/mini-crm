<?php

namespace Tests\Feature;

use App\Company;
use App\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompaniesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function a_list_of_companies_can_be_fetched()
    {
        factory(Company::class, 5)->create();
        $response = $this->get('/api/companies?api_token=' . $this->user->api_token);
        $response->assertJsonCount(5);
    }

    /** @test */
    public function an_unauthenticated_user_should_be_redirected_to_login()
    {
        $response = $this->post('/api/companies',
            array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function an_authenticated_user_can_add_a_company()
    {
        $response = $this->post('/api/companies', $this->data());

        $company = Company::first();

        $this->assertEquals('CompanyName', $company->name);
        $this->assertEquals('company@mail.com', $company->email);
//        $this->assertEquals('logo.jpg', $company->logo);
        $this->assertEquals('www.company.com', $company->website);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'company_id' => $company->id
            ],
            'links' => [
                'self' => $company->path()
            ]
        ]);
    }

    /** @test */
    public function email_must_be_a_valid_email()
    {
        $response = $this->post('/api/companies',
            array_merge($this->data(), ['email' => 'NOT EMAIL']));

        $response->assertSessionHasErrors('email');
        $this->assertCount(0, Company::all());
    }

    /** @test */
    public function a_company_can_be_retrieved()
    {
        $company = factory(Company::class)->create();
        $response = $this->get('/api/companies/' . $company->id . '?api_token=' . $this->user->api_token);

        $response->assertJson([
            'data' => [
                'company_id' => $company->id,
                'name' => $company->name,
                'email' => $company->email,
//                'logo' => $company->logo,
                'website' => $company->website
            ]
        ]);
    }

    /** @test */
    public function a_company_can_be_patched()
    {
        $company = factory(Company::class)->create();

        $response = $this->patch('/api/companies/' . $company->id, $this->data());

        $company = $company->fresh();

        $this->assertEquals('CompanyName', $company->name);
        $this->assertEquals('company@mail.com', $company->email);
//        $this->assertEquals('logo.jpg', $company->logo);
        $this->assertEquals('www.company.com', $company->website);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'company_id' => $company->id
            ],
            'links' => [
                'self' => $company->path()
            ]
        ]);
    }

    /** @test */
    public function only_admin_can_patch_the_company()
    {
        $company = factory(Company::class)->create();

        $anotherUser = factory(User::class)->create(['is_admin' => false]);

        $response = $this->patch('/api/companies/' . $company->id,
            array_merge($this->data(), ['api_token' => $anotherUser->api_token]));

        $response->assertStatus(403);
    }

    /** @test */
    public function a_company_can_be_deleted()
    {
        $company = factory(Company::class)->create();

        $response = $this->delete('/api/companies/' . $company->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, Company::all());

        $response->assertStatus(Response::HTTP_NO_CONTENT);

    }

    /** @test */
    public function only_admin_can_delete_the_company()
    {
        $company = factory(Company::class)->create();

        $anotherUser = factory(User::class)->create(['is_admin' => false]);

        $response = $this->delete('/api/companies/' . $company->id, ['api_token' => $anotherUser->api_token]);

        $response->assertStatus(403);

    }

    private function data()
    {
        return [
            'name' => 'CompanyName',
            'email' => 'company@mail.com',
//            'logo' => 'logo.jpg',
            'website' => 'www.company.com',
            'api_token' => $this->user->api_token
        ];
    }
}
