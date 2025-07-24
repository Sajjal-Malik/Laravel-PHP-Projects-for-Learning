<?php

namespace App\Console\Commands;

use App\Enums\AgeStatus;
use App\Models\Profile;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateAgeStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "profiles:update-age-status";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Update ageStatus for all profiles based on age and gender";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $profiles = Profile::all();

            foreach ($profiles as $profile) {
                $newStatus = $this->determineAgeStatus($profile->age, $profile->gender);

                if ($newStatus && $profile->ageStatus !== $newStatus) {
                    $profile->ageStatus = $newStatus;
                    $profile->save();
                }
            }

            $this->info("Age statuses updated Successfully");
            
            Log::info('Age statuses updated successfully.');

            return Command::SUCCESS;

        } catch (Exception $e) {

            Log::error('Failed to update age statuses: ' . $e->getMessage());

            $this->error('Failed to update age statuses.');

            return Command::FAILURE;
        }
    }

    private function determineAgeStatus($age, $gender)
    {
        return match (true) {

            $gender === 'Female' && $age >= 1 && $age <= 20 => AgeStatus::KID_FEMALE,
            $gender === 'Female' && $age >= 21 && $age <= 40 => AgeStatus::YOUNG_FEMALE,
            $gender === 'Female' && $age >= 41 && $age <= 60 => AgeStatus::ELDER_FEMALE,
            $gender === 'Female' && $age >= 61 && $age <= 90 => AgeStatus::FEMALE,

            $gender === 'Male' && $age >= 1 && $age <= 15 => AgeStatus::KID_MALE,
            $gender === 'Male' && $age >= 16 && $age <= 40 => AgeStatus::YOUNG_MALE,
            $gender === 'Male' && $age >= 41 && $age <= 60 => AgeStatus::ELDER_MALE,
            $gender === 'Male' && $age >= 61 && $age <= 90 => AgeStatus::MALE,

            default => null
        };
    }
}
