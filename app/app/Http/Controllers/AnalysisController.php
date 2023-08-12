<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class AnalysisController extends Controller
{
    public function index()
    {
        $startDate = '2022-07-01';
        $endDate = '2023-07-31';

//        $period = Order::betweenDate($startDate, $endDate)
//            ->groupBy('id')
//            ->selectRaw('id, sum(subtotal) as total, customer_name, status, created_at')
//            ->orderBy('created_at')
//            ->paginate(50);

//        $subQuery = Order::betweenDate($startDate, $endDate)
//            ->where('status', true)
//            ->groupBy('id')
//            ->selectRaw('id, sum(subtotal) as totalPerPurchase, DATE_FORMAT(created_at, "%Y%m%d") as date');
//
//        $data = DB::table($subQuery)
//            ->groupBy('date')
//            ->selectRaw('date, sum(totalPerPurchase) as total')
//            ->get();

//        dd($data);

//        $subQuery = Order::betweenDate($startDate, $endDate)
//            ->groupBy('id')
//            ->selectRaw('id, customer_id, customer_name, SUM(subtotal) as totalPerPurchase');
//
//        $subQuery = DB::table($subQuery)
//            ->groupBy('customer_id')
//            ->selectRaw('customer_id, customer_name, SUM(totalPerPurchase) as total')
//            ->orderBy('total', 'desc');
//
//        DB::statement('set @row_num = 0;');
//        $subQuery = DB::table($subQuery)
//            ->selectRaw('
//                @row_num:= @row_num+1 as row_num,
//                customer_id,
//                customer_name,
//                total
//            ');



//        $count = DB::table($subQuery)->count();
//        $total = DB::table($subQuery)->selectRaw('SUM(total) as total')->get();
//        $total = $total[0]->total;
//
//        $decile = ceil($count / 10);
//
//        $bindValues = [];
//        $tempValue = 0;
//        for ($i=1; $i<=10; $i++) {
//            array_push($bindValues, 1 + $tempValue);
//            $tempValue += $decile;
//            array_push($bindValues, 1 + $tempValue);
//        }

//        dd($count, $decile, $bindValues);

//        DB::statement('set @row_num = 0;');
//        $subQuery = DB::table($subQuery)
//            ->selectRaw("
//                row_num,
//                customer_id,
//                customer_name,
//                total,
//                case
//                    when ? <= row_num and row_num < ? then 1
//                    when ? <= row_num and row_num < ? then 2
//                    when ? <= row_num and row_num < ? then 3
//                    when ? <= row_num and row_num < ? then 4
//                    when ? <= row_num and row_num < ? then 5
//                    when ? <= row_num and row_num < ? then 6
//                    when ? <= row_num and row_num < ? then 7
//                    when ? <= row_num and row_num < ? then 8
//                    when ? <= row_num and row_num < ? then 9
//                    when ? <= row_num and row_num < ? then 10
//                end as decile
//            ", $bindValues);

//        dd($subQuery);

//        $subQuery = DB::table($subQuery)
//            ->groupBy('decile')
//            ->selectRaw('
//                decile,
//                round(avg(total)) as average,
//                sum(total) as totalPerGroup
//            ');

//        dd($subQuery);

//        DB::statement("set @total = ${total};");
//        $data = DB::table($subQuery)
//            ->selectRaw('
//                decile,
//                average,
//                totalPerGroup,
//                round(100 * totalPerGroup / @total, 1) as totalRatio
//            ')->get();

//        dd($data);




        // 1. 購買id毎にまとめる
        $subQuery = Order::betweenDate($startDate, $endDate)
            ->groupBy('id')
            ->selectRaw('
                id,
                customer_id,
                customer_name,
                SUM(subtotal) as totalPerPurchase, created_at
            ');

        // 2. 会員毎にまとめて最終購入日、回数う、合計金額を取得。
        $subQuery = DB::table($subQuery)
            ->groupBy('customer_id')
            ->selectRaw('
                customer_id,
                customer_name,
                MAX(created_at) as recentDate,
                datediff(now(), MAX(created_at)) as recency,
                count(customer_id) as frequency,
                SUM(totalPerPurchase) as monetary
            ')->get();

        dd($subQuery);

        return Inertia::render('Analysis');
    }
}
