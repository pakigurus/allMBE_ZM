<?php

namespace App\Console\Commands\Masajid;

use App\Facades\Google\GoogleApi;
use App\Model\Masajid;
use Illuminate\Console\Command;

class MasajidAddressesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'masajid:addresses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $googleApi = new GoogleApi();
        $masajids = Masajid::all();

        foreach ($masajids->where('country', null)->values() as $masajid) {
            $rawResponse = $googleApi->masajidPlaceCountry($masajid);
            $results = data_get($rawResponse, 'results');

            foreach ($results[0]->address_components as $address) {
                if (in_array("locality", $address->types)) {
                    $masajid->city = $address->long_name;
                } else if(in_array("country", $address->types)){
                    $masajid->country = $address->long_name;
                } else if(in_array("administrative_area_level_1", $address->types)){
                    $masajid->state = $address->long_name;
                }
            }
            $masajid->save();
        }

        return true;
    }
}
