<?php

namespace App\Repositories\Repository;

use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Traits\FileUploadTrait;

class CompanyRepository implements CompanyRepositoryInterface
{
    use FileUploadTrait;
    public function all()
    {
        try {
            return Company::all();
            
        } catch(Exception $e) {

            throw new Exception('Failed to Load Companies' . $e->getMessage());
        }
    }

    public function find($id)
    {
        try{
            return Company::findOrFail($id);
        }
        catch(Exception $e){

            throw new Exception('Compnay Not Found' . $e->getMessage());
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

        } catch (Exception $e) {

            DB::rollBack();

            throw new Exception('Failed to Save Company Data' . $e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try{
            DB::beginTransaction();

            $company = Company::findOrFail($id);

            if (isset($data['logo'])) {

                $this->deleteLogo($company->logo);

                $data['logo'] = $this->uploadLogo($data['logo']);
            }

            $company->update($data);

            DB::commit();

            return $company;
        }
        catch(Exception $e){
            
            DB::rollBack();

            throw new Exception('Failed to Update Company Data' . $e->getMessage());
        }   
    }

    public function delete($id)
    {
        try{
            return Company::destroy($id);
        }
        catch(Exception $e){
            
            throw new Exception('Failed to Delete Company' . $e->getMessage());
        }
    }
}