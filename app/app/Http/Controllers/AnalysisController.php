<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;
use Inertia\Inertia;

class AnalysisController extends Controller
{
    public function index()
    {
        $startDate = '2023-07-01';
        $endDate = '2023-07-31';

        $period = Order::betweenDate($startDate, $endDate)
            ->groupBy('id')
            ->selectRaw('id, sum(subtotal) as total, customer_name, status, created_at')
            ->orderBy('created_at')
            ->paginate(50);

        return Inertia::render('Analysis');
    }
}
