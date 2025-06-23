<?php

namespace App\Repositories\Eloquent;

use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;

class CompanyRepository implements CompanyRepositoryInterface
{

    use FileUploadTrait;

    public function all()
    {
        try {

            return Company::all();
            
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function store(array $data)
    {

        try {

            DB::beginTransaction();

            if (isset($data['logo'])) {

                $data['logo'] = $this->uploadLogo($data['logo']);
            }
            $company = Company::create($data);

            DB::commit();

            return $company;
        } catch (\Throwable $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public function find($id)
    {
        try {
            return Company::findOrFail($id);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function update($id, array $data)
    {

        try {
            DB::beginTransaction();
            
            $company = Company::findOrFail($id);

            if (isset($data['logo'])) {

                $this->deleteLogo($company->logo);

                $data['logo'] = $this->uploadLogo($data['logo']);
            }

            $company->update($data);

            DB::commit();

            return $company;
        } catch (\Throwable $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public function delete($id)
    {
        try {
            return Company::destroy($id);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
}
