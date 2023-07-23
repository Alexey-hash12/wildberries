<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Order;
use App\Models\Warehouse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request)
    {
        $incomes = Income::query();

        $session = session()->get('message');

        $incomes = $this->filter($incomes, $request);

        $incomes = $this->sort($incomes, $request);

        $incomes = $incomes->paginate(40);

        $wareHouses = Warehouse::get();

        return view('index', compact('session', 'incomes', 'wareHouses'));
    }

    public function show(Request $request, $incomeId)
    {
        $session = session()->get('message');

        $income = Income::where('incomeId', $incomeId)->firstOrFail();

        $orders = Order::where('incomeId', $incomeId);


        $orders = $this->filter($orders, $request);

        $orders = $this->sort($orders, $request);

        $orders = $orders->paginate(10);

        return view('show', compact('session', 'income', 'orders'));
    }


    private function filter($products, $request)
    {
        foreach ($request->all() as $key => $requestField) {
            if (!$requestField) {
                continue;
            }

            $requestData = explode('-', $key);
            if (count($requestData) > 1) {
                if ($requestData[1] == 'search') {
                    $products->where($requestData[0], 'like', "%$requestField%");
                } else if ($requestData[1] == 'in') {
                    if ($requestField == 'true') {
                        $products->where($requestData[0], '=', true);
                    } else {
                        $products->where($requestData[0], '=', false);
                    }
                } else if ($requestData[1] == 'from') {
                    $products->having($requestData[0], '>=', $requestField);
                } else if ($requestData[1] == 'to') {
                    $products->having($requestData[0], '<=',  $requestField);
                }
            }
        }


        if ($request->get('filter_name') && $request->get('filter_value')) {
            $products->where($request->get('filter_name'), 'like', "%{$request->get('filter_value')}%");
        }

        if ($request->get('budget_from')) {
            $products->where($request->get('budget_from'), '>=', 'BUDGET');
        }

        return $products;
    }

    public function sort($products, $request)
    {
        if ($request->get('sort_type') && $request->get('sort_value')) {
            $products->orderBy($request->get('sort_type'), $request->get('sort_value'));
        }

        return $products;
    }
}
