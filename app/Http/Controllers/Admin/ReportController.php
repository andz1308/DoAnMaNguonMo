<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\User;
use App\Models\ThanhToan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'daily');
        $start = $request->get('start_date');
        $end = $request->get('end_date');
        $viewAll = $request->get('view_all'); 

        if ($viewAll) {
            $firstDate = ThanhToan::min('ngay_thanh_toan');
            $startDate = $firstDate ? Carbon::parse($firstDate) : Carbon::now()->startOfYear();
            $endDate = Carbon::now();

            $period = 'monthly';
        } else {
            $endDate = $end ? Carbon::parse($end)->endOfDay() : Carbon::now()->endOfDay();
            $startDate = $start ? Carbon::parse($start)->startOfDay() : $endDate->copy()->subDays(29)->startOfDay();
        }

        
        $totalOrders = DonHang::whereBetween('created_at', [$startDate, $endDate])->count();

        
        $totalUsers = User::count();

        $totalRevenue = ThanhToan::whereBetween('ngay_thanh_toan', [$startDate, $endDate])->sum('tong_tien');

        $recentOrders = DonHang::select('don_hang.*')
            ->join('thanh_toan', 'don_hang.id', '=', 'thanh_toan.don_hang_id')
            ->with(['user', 'thanhToan'])
            ->whereBetween('thanh_toan.ngay_thanh_toan', [$startDate, $endDate]) 
            ->orderByDesc('thanh_toan.ngay_thanh_toan')
            ->limit(10)
            ->get();

        $labels = [];
        $data = [];


        if ($period === 'monthly') {
            $periodStart = $startDate->copy()->startOfMonth();
            $periodEnd = $endDate->copy()->endOfMonth();
            $cursor = $periodStart->copy();
            while ($cursor->lte($periodEnd)) {
                $labels[] = $cursor->format('m/Y');
                $count = ThanhToan::whereYear('ngay_thanh_toan', $cursor->year)
                    ->whereMonth('ngay_thanh_toan', $cursor->month)
                    ->count(); 
                $data[] = $count;
                $cursor->addMonth();
            }
        } elseif ($period === 'yearly') {
            $periodStart = $startDate->copy()->startOfYear();
            $periodEnd = $endDate->copy()->endOfYear();
            $cursor = $periodStart->copy();
            while ($cursor->lte($periodEnd)) {
                $labels[] = $cursor->format('Y');
                $count = ThanhToan::whereYear('ngay_thanh_toan', $cursor->year)->count();
                $data[] = $count;
                $cursor->addYear();
            }
        } else {
            $cursor = $startDate->copy();
            while ($cursor->lte($endDate)) {
                $labels[] = $cursor->format('d/m');
                $count = ThanhToan::whereDate('ngay_thanh_toan', $cursor->toDateString())->count();
                $data[] = $count;
                $cursor->addDay();
            }
        }

        $chartLabels = json_encode($labels);
        $chartData = json_encode($data);


        $topProducts = DB::table('chi_tiet_don_hang')
            ->join('don_hang', 'chi_tiet_don_hang.don_hang_id', '=', 'don_hang.id')
            ->join('thanh_toan', 'don_hang.id', '=', 'thanh_toan.don_hang_id') 
            ->join('san_pham', 'chi_tiet_don_hang.san_pham_id', '=', 'san_pham.id')
            ->whereBetween('thanh_toan.ngay_thanh_toan', [$startDate, $endDate])
            ->select(
                'san_pham.id',
                'san_pham.name', 
                DB::raw('SUM(chi_tiet_don_hang.so_luong) as tong_so_luong'),
                DB::raw('SUM(chi_tiet_don_hang.so_luong * san_pham.gia) as tong_doanh_thu')
            )
            ->groupBy('san_pham.id', 'san_pham.name') 
            ->orderByDesc('tong_so_luong') 
            ->limit(5)
            ->get();

        return view('admin.reports.index', compact(
            'totalOrders',
            'totalUsers',
            'totalRevenue',
            'recentOrders',
            'chartLabels',
            'chartData',
            'period',
            'startDate',
            'endDate',
            'topProducts' 
        ));
    }
}