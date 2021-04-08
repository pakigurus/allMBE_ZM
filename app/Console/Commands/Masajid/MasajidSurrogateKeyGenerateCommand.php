<?php

namespace App\Console\Commands\Masajid;

use App\Facades\Utilities\Utilities;
use App\Model\Masajid;
use Illuminate\Console\Command;

class MasajidSurrogateKeyGenerateCommand extends Command
{
    use Utilities;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'masajid:key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate key';

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
        $masajids = Masajid::all();
        foreach ($masajids->where('country', '!=',null)->values() as $masajid) {
            $key = $this->generateSurrogateId($masajid->country, $masajid->city, $masajid->id);
            $masajid->update(['surrogate_id' => $key]);
        }
        return true;
    }
}
