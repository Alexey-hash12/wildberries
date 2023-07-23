<?php

namespace App\Console\Commands;

use App\Models\Income;
use App\Models\Order;
use App\Models\Warehouse;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ParseWildWarehouses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-wild-warehouses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Парсинг складов';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $log = Log::build([
            'driver' => 'daily',
            'path' => storage_path('logs/schedule/wild-warehouses/wild-warehouse.log')
        ]);

        $url = "https://suppliers-api.wildberries.ru/api/v3/warehouses";
        $authorization = 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NJRCI6IjJhZjU4NmNmLThiYTQtNDIyYy05ZjIwLWQ1MDgzZDE4Y2RhNyJ9.D6oaVvwuW6KPho1tBMlPfToMU4Sh8lM9tdY4PtRVJCQ';

        $error = 0;
        $success = 0;
        $log->info('Starting...');

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                $authorization
            ],
        ];

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        curl_close($curl);


        $data = json_decode($response, true);
        if (count($data)) {
            foreach ($data as $item) {
                try {
                    $warehouse = new Warehouse();
                    $warehouse->name = Arr::get($item, 'name');
                    $warehouse->officeId = Arr::get($item, 'officeId');
                    $warehouse->warehouseId = Arr::get($item, 'id');
                    $warehouse->save();
                    $success ++;
                } catch (\Exception $exception) {
                    $error ++;
                    $this->error('Error: '. $exception->getMessage());
                    $log->error('Error: '. $exception->getMessage());
                }
            }
        }

        $log->info("Results: error - $error, success - $success");

        return 0;
    }
}
