<?php

namespace App\Http\Controllers;

use App\DTO\Company\CreateCompanyDto;
use App\DTO\Company\UpdateCompanyDto;
use App\Http\Resources\Company\CompanyResource;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Services\CompanyService\ICompanyService;

class CompanyController extends Controller
{
    private ICompanyService $companyService;

    public function __construct(ICompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index()
    {
        return CompanyResource::collection($this->companyService->getAllCompany());
    }

    public function show(string $id)
    {
        return new CompanyResource($this->companyService->getCompanyById((int) $id));
    }

    public function store(StoreCompanyRequest $request)
    {
        $validated = $request->validated();
        $createCompanyDto = new CreateCompanyDto(
            name: $validated['name'],
            description: $validated['description'],
        );

        return new CompanyResource(
            $this->companyService->createCompany($createCompanyDto, $request->user())
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

        return new CompanyResource(
            $this->companyService->updateCompany($updateCompanyDto, $request->user())
        );
    }

}
