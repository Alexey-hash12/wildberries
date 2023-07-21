<?php

namespace App\Console\Commands;

use App\Models\Income;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ParseWild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-wild';

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
        $url = 'https://suppliers-api.wildberries.ru/api/v3/supplies';
        $authorization = 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NJRCI6IjJhZjU4NmNmLThiYTQtNDIyYy05ZjIwLWQ1MDgzZDE4Y2RhNyJ9.D6oaVvwuW6KPho1tBMlPfToMU4Sh8lM9tdY4PtRVJCQ';
        $log = Log::build([
            'driver' => 'daily',
            'path' => storage_path('logs/schedule/wild/wild.log')
        ]);

        $error = 0;
        $success = 0;
        $log->info('Starting...');

        $this->getData($log, $url, $authorization, $error, $success);

        $log->info("Results: error - $error, success - $success");

        return 0;
    }

    /**
     * @param $log
     * @param $url
     * @param $authorization
     * @param $error
     * @param $success
     * @param int $next
     */
    public function getData($log, $url, $authorization, &$error, &$success, $next = 0)
    {
        $data = $this->send($url, $authorization, $next);

        if (count($data) && Arr::get($data, 'supplies')) {
            foreach (Arr::get($data,'supplies') as $datum) {
                try {
                    if (!$income = Income::query()->where('incomeId', Arr::get($datum, 'id'))->first()) {
                        $income = new Income();
                    }

                    $income->incomeId = Arr::get($datum, 'id');
                    $income->done = Arr::get($datum, 'done');
                    $income->createdAt = Carbon::parse(Arr::get($datum, 'createdAt'));
                    $income->closedAt = Arr::get($datum, 'closedAt') ? Carbon::parse(Arr::get($datum, 'closedAt')) : null;
                    $income->scanDt = Arr::get($datum, 'scanDt') ? Carbon::parse(Arr::get($datum, 'scanDt')) : null;
                    $income->name = Arr::get($datum, 'name');
                    $income->isLargeCargo = Arr::get($datum, 'isLargeCargo') ?? false;

                    $income->save();
                    $success ++;
                    echo '.';
                } catch (\Exception $exception) {
                    $log->error('Error: ' . $exception->getMessage());
                    $error ++;
                }
            }

            if (Arr::get($data, 'next') && Arr::get($data, 'next') != 0) {
                $this->getData($log, $url, $authorization, $error, $success, Arr::get($data, 'next'));
            }
        }
    }

    /**
     * @param $url
     * @param $authorization
     * @param int $next
     * @return array
     */
    private function send($url, $authorization, $next = 0): array
    {
        $options = [
            CURLOPT_URL => $url . '?limit=1000&next=' . $next,
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

        return json_decode($response, true);
    }
}
