<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $incomes = Income::query();

        $session = session()->get('message');

        $incomes = $incomes->paginate(40);

        return view('index', compact('session', 'incomes'));
    }
}
