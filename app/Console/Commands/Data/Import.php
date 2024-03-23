<?php

namespace App\Console\Commands\Data;

use App\Exceptions\ParseException;
use App\Models\City;
use App\Models\CountryDistrict;
use App\Models\CountryZone;
use App\Services\ParseDataService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse city data from "www.e-obce.sk"';

    /**
     * Execute the console command.
     * @throws Throwable
     */
    public function handle(ParseDataService $parseDataService): void
    {
        $countryZoneModel = CountryZone::find(1);

        DB::beginTransaction();

        try {
            $districts = $parseDataService->getDistricts();
            foreach ($districts as $district) {
                $districtModel = CountryDistrict::firstOrCreate([
                    'country_zone_id' => $countryZoneModel->id,
                    'name' => $district->name,
                ]);
                $cities = $parseDataService->getCities($district);
                foreach ($cities as $city) {
                    $cityDetail = $parseDataService->getCityDetail($city);
                    $cityModel = City::firstOrNew([
                        'country_district_id' => $districtModel->id,
                        'name' => $cityDetail->name,
                    ]);
                    $cityModel->mayor_name = $cityDetail->mayorName;
                    $cityModel->address = $cityDetail->address;
                    $cityModel->phone = $cityDetail->phone;
                    $cityModel->fax = $cityDetail->fax;
                    $cityModel->email = $cityDetail->email;
                    $cityModel->web = $cityDetail->web;
                    $cityModel->save();
                }
            }

            DB::commit();
            $this->info('Import is complete.');
        } catch (ParseException $e) {
            DB::rollBack();
            $this->error($e->getMessage());
        } catch (Throwable) {
            DB::rollBack();
            $this->error('An unexpected error occurred.');
        }
    }
}
