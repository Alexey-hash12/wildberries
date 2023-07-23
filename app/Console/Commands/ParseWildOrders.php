<?php

namespace App\Console\Commands;

use App\Models\Income;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ParseWildOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-wild-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $log = Log::build([
            'driver' => 'daily',
            'path' => storage_path('logs/schedule/wild-orders/wild-orders.log')
        ]);

        foreach (Income::get() as $income) {
            $url = "https://suppliers-api.wildberries.ru/api/v3/supplies/{$income->incomeId}/orders";
            $authorization = 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NJRCI6IjJhZjU4NmNmLThiYTQtNDIyYy05ZjIwLWQ1MDgzZDE4Y2RhNyJ9.D6oaVvwuW6KPho1tBMlPfToMU4Sh8lM9tdY4PtRVJCQ';

            $error = 0;
            $success = 0;
            $log->info('Starting for income: ' . $income->incomeId);

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
            if (count($data) && Arr::get($data, 'orders')) {
                foreach (Arr::get($data, 'orders') as $item) {
                    try {
                        if (!$order = Order::query()->where('incomeId', $income->incomeId)->where('orderId', Arr::get($item, 'id'))->first()) {
                            $order = new Order();
                        }

                        $order->incomeId = $income->incomeId;
                        $order->orderId = Arr::get($item, 'id');
                        $order->rid = Arr::get($item, 'rid');
                        $order->article = Arr::get($item, 'article');
                        $order->orderUid = Arr::get($item, 'orderUid');
                        $order->warehouseId = Arr::get($item, 'warehouseId');
                        $order->skus = Arr::get($item, 'skus', []);
                        $order->user = Arr::get($item, 'user', []);
                        $order->nmId = Arr::get($item, 'nmId');
                        $order->currencyCode = Arr::get($item, 'currencyCode');
                        $order->price = Arr::get($item, 'price');
                        $order->convertedPrice = Arr::get($item, 'convertedPrice');
                        $order->isLargeCargo = Arr::get($item, 'isLargeCargo');
                        $order->createdAt = Arr::get($item, 'createdAt') ? Carbon::parse(Arr::get($item, 'createdAt')) : null;
                        $order->chrtId = Arr::get($item, 'chrtId');
                        $order->save();
                        echo '.';
                        $success ++;
                    } catch (\Exception $exception) {
                        $error ++;
                        $this->error('Error: '. $exception->getMessage());
                        $log->error('Error: '. $exception->getMessage());
                    }
                }
            }

            $log->info("Results: error - $error, success - $success");
        }

        return 0;
    }
}
