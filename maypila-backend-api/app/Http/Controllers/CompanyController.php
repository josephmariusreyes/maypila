<?php

namespace App\Http\Controllers;

use App\DTO\Company\CreateCompanyDto;
use App\DTO\Company\UpdateCompanyDto;
use App\Http\Resources\ApiBaseResponse;
use App\Http\Resources\Company\CompanyResource;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Services\CompanyService\CompanyService;

class CompanyController extends Controller
{
    private CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index()
    {
        return ApiBaseResponse::success(
            data: CompanyResource::collection($this->companyService->getAllCompany()),
            message: 'Companies fetched successfully'
        );
    }

    public function show(string $id)
    {
        return ApiBaseResponse::success(
            data: new CompanyResource($this->companyService->getCompanyById((int) $id)),
            message: 'Company fetched successfully'
        );
    }

    public function store(StoreCompanyRequest $request)
    {
        $validated = $request->validated();
        $createCompanyDto = new CreateCompanyDto(
            name: $validated['name'],
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
