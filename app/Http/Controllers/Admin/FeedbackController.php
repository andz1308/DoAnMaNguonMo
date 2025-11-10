<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::with('user');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('chu_de', 'like', "%{$search}%")
                  ->orWhere('noi_dung', 'like', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('trang_thai', $request->status);
        }

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->where('loai', $request->type);
        }

    $dateCol = Schema::hasColumn('feedback', 'created_at') ? 'created_at' : 'id';
    $feedbacks = $query->orderByDesc($dateCol)->paginate(15);

        // Statistics
        $totalFeedback = Feedback::count();
        $pendingFeedback = Feedback::where('trang_thai', 0)->count();
        $processedFeedback = Feedback::where('trang_thai', 1)->count();
    $todayFeedback = Schema::hasColumn('feedback', 'created_at') ? Feedback::whereDate('created_at', today())->count() : 0;

        return view('admin.feedback.index', compact(
            'feedbacks',
            'totalFeedback',
            'pendingFeedback',
            'processedFeedback',
            'todayFeedback'
        ));
    }

    public function show($id)
    {
        $feedback = Feedback::with('user')->findOrFail($id);
        
        $typeText = 'Khác';
        switch($feedback->loai ?? 'other') {
            case 'complain':
                $typeText = 'Khiếu nại';
                break;
            case 'suggestion':
                $typeText = 'Đề xuất';
                break;
            case 'question':
                $typeText = 'Câu hỏi';
                break;
        }

        $html = '
        <div class="row">
            <div class="col-md-6">
                <h6>Thông tin người gửi</h6>
                <p><strong>Tên:</strong> ' . ($feedback->user->name ?? 'Khách') . '</p>
                <p><strong>Email:</strong> ' . ($feedback->user->email ?? $feedback->email ?? 'N/A') . '</p>
            </div>
            <div class="col-md-6">
                <h6>Thông tin phản hồi</h6>
                <p><strong>Loại:</strong> ' . $typeText . '</p>
                <p><strong>Trạng thái:</strong> ' . (($feedback->trang_thai ?? 0) == 0 ? '<span class="badge bg-warning">Chờ xử lý</span>' : '<span class="badge bg-success">Đã xử lý</span>') . '</p>
            </div>
        </div>
        <div class="mt-3">
            <h6>Chủ đề</h6>
            <p>' . ($feedback->chu_de ?? 'N/A') . '</p>
        </div>
        <div class="mt-3">
            <h6>Nội dung</h6>
            <p>' . ($feedback->noi_dung ?? 'Không có nội dung') . '</p>
        </div>
        <div class="mt-3">
            <p class="text-muted"><small>Ngày gửi: ' . ($feedback->created_at ? $feedback->created_at->format('d/m/Y H:i') : 'N/A') . '</small></p>
        </div>
        ';

        return response($html);
    }

    public function markAsProcessed($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->update(['trang_thai' => 1]);

        return response()->json(['success' => true]);
    }

    public function markAsPending($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->update(['trang_thai' => 0]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return response()->json(['success' => true]);
    }

    public function bulkMarkProcessed(Request $request)
    {
        Feedback::whereIn('id', $request->ids)->update(['trang_thai' => 1]);
        return response()->json(['success' => true]);
    }

    public function bulkDelete(Request $request)
    {
        Feedback::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => true]);
    }
}
