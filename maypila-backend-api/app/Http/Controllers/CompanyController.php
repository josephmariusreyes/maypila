<?php

namespace App\Http\Controllers;

use App\DTO\Company\CreateCompanyDto;
use App\DTO\Company\UpdateCompanyDto;
use App\Http\Resources\ApiBaseResponse;
use App\Http\Resources\Company\CompanyResource;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Services\CompanyService\CompanyService;
use Knuckles\Scribe\Attributes\Response;

class CompanyController extends Controller
{

    public function __construct(
        private CompanyService $companyService
    ) {}

    #[Response([
        'success' => true,
        'message' => 'Success',
        'data' => new \stdClass(),
        'meta' =>  new \stdClass()
    ])]
    public function index()
    {
        return ApiBaseResponse::success(
            data: CompanyResource::collection($this->companyService->getAllCompany()),
            message: 'Companies fetched successfully'
        );
    }

    #[Response([
        'success' => true,
        'message' => 'Success',
        'data' => new \stdClass(),
        'meta' =>  new \stdClass()
    ])]
    public function show(string $id)
    {
        return ApiBaseResponse::success(
            data: new CompanyResource($this->companyService->getCompanyById((int) $id)),
            message: 'Company fetched successfully'
        );
    }

    #[Response([
        'success' => true,
        'message' => 'Success',
        'data' => new \stdClass(),
        'meta' =>  new \stdClass()
    ])]
    public function store(StoreCompanyRequest $request)
    {
        $validated = $request->validated();
        $createCompanyDto = new CreateCompanyDto(
            name: $validated['name'],
            company_email: $validated['company_email'],
            description: $validated['description'],
        );

        return ApiBaseResponse::success(
            data: new CompanyResource(
                $this->companyService->createCompany($createCompanyDto, $request->user())
            ),
            message: 'Company created successfully',
            status: 201
        );
    }

    #[Response([
        'success' => true,
        'message' => 'Success',
        'data' => new \stdClass(),
        'meta' =>  new \stdClass()
    ])]
    public function update(StoreCompanyRequest $request, $id)
    {
        $validated = $request->validated();
        $updateCompanyDto = new UpdateCompanyDto(
            id: (string) $id,
            name: $validated['name'],
            description: $validated['description'],
        );

        return ApiBaseResponse::success(
            data: new CompanyResource(
                $this->companyService->updateCompany($updateCompanyDto, $request->user())
            ),
            message: 'Company updated successfully'
        );
    }
}
