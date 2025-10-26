<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\User;
use App\Models\ThanhToan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $totalOrders = DonHang::count();
        $totalUsers = User::count();
        $totalRevenue = ThanhToan::sum('tong_tien');

        // recent orders
        $recentOrders = DonHang::with(['user', 'thanhToan'])->orderByDesc('id')->limit(10)->get();

        // Chart parameters
        $period = $request->get('period', 'daily'); // daily, monthly, yearly
        $start = $request->get('start_date');
        $end = $request->get('end_date');

        // Default date range: last 30 days
        $endDate = $end ? Carbon::parse($end) : Carbon::now();
        $startDate = $start ? Carbon::parse($start) : $endDate->copy()->subDays(29);

        // Build series depending on period
        $labels = [];
        $data = [];

    // detect available date column on don_hang; fallback to thanh_toan.ngay_thanh_toan
    $hasCreatedAt = Schema::hasColumn('don_hang', 'created_at');
    $hasThanhToanDate = Schema::hasColumn('thanh_toan', 'ngay_thanh_toan');

    if ($period === 'monthly') {
            $periodStart = $startDate->copy()->startOfMonth();
            $periodEnd = $endDate->copy()->endOfMonth();
            $months = [];
            $cursor = $periodStart->copy();
            while ($cursor->lte($periodEnd)) {
                $months[] = $cursor->format('Y-m');
                $cursor->addMonth();
            }

            foreach ($months as $m) {
                $labels[] = Carbon::parse($m . '-01')->format('M Y');
                [$year, $mon] = explode('-', $m);
                if ($hasCreatedAt) {
                    $count = DonHang::whereYear('created_at', $year)->whereMonth('created_at', $mon)->count();
                } elseif ($hasThanhToanDate) {
                    $count = DonHang::whereHas('thanhToan', function($q) use ($year, $mon) {
                        $q->whereYear('ngay_thanh_toan', $year)->whereMonth('ngay_thanh_toan', $mon);
                    })->count();
                } else {
                    $count = 0;
                }
                $data[] = $count;
            }
        } elseif ($period === 'yearly') {
            $yearStart = $startDate->copy()->startOfYear();
            $yearEnd = $endDate->copy()->endOfYear();
            $years = [];
            $cursor = $yearStart->copy();
            while ($cursor->lte($yearEnd)) {
                $years[] = $cursor->format('Y');
                $cursor->addYear();
            }

            foreach ($years as $y) {
                $labels[] = $y;
                if ($hasCreatedAt) {
                    $count = DonHang::whereYear('created_at', $y)->count();
                } elseif ($hasThanhToanDate) {
                    $count = DonHang::whereHas('thanhToan', function($q) use ($y) {
                        $q->whereYear('ngay_thanh_toan', $y);
                    })->count();
                } else {
                    $count = 0;
                }
                $data[] = $count;
            }
        } else {
            // daily
            $cursor = $startDate->copy();
            while ($cursor->lte($endDate)) {
                $labels[] = $cursor->format('d/m/Y');
                if ($hasCreatedAt) {
                    $count = DonHang::whereDate('created_at', $cursor->toDateString())->count();
                } elseif ($hasThanhToanDate) {
                    $count = DonHang::whereHas('thanhToan', function($q) use ($cursor) {
                        $q->whereDate('ngay_thanh_toan', $cursor->toDateString());
                    })->count();
                } else {
                    $count = 0;
                }
                $data[] = $count;
                $cursor->addDay();
            }
        }

        // Pass JSON-encoded arrays for Chart.js
        $chartLabels = json_encode($labels);
        $chartData = json_encode($data);

        return view('admin.reports.index', compact('totalOrders', 'totalUsers', 'totalRevenue', 'recentOrders', 'chartLabels', 'chartData', 'period', 'startDate', 'endDate'));
    }
}
