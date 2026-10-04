<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    // สำหรับแสดงหน้า UI ลางาน
    public function index()
{
    // ถ้ายังไม่ได้เข้าสู่ระบบ ให้แสดงหน้า Portal ต้อนรับของระบบลา
    if (!auth()->check()) {
        return view('leave.welcome');
    }

    // ถ้าเข้าสู่ระบบแล้ว ให้แสดงหน้ายื่นใบลาตามปกติ
    $leaves = LeaveRequest::with('user')->orderBy('created_at', 'desc')->get();
    return view('leave.index', compact('leaves'));
}

    // บันทึกการขอลางาน
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string'
        ]);

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $total_days = $start->diffInDays($end) + 1;
        $user = Auth::user();

        if ($total_days > $user->remaining_leave_days) {
            return back()->with('error', 'วันลาคงเหลือไม่เพียงพอ');
        }

        LeaveRequest::create([
            'user_id' => $user->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_days' => $total_days,
            'reason' => $request->reason,
        ]);

        return back()->with('success', 'ส่งคำขอลาสำเร็จ');
    }

    // อนุมัติ/ปฏิเสธใบลา
    public function updateStatus(Request $request, LeaveRequest $leave)
    {
        if (Auth::user()->role !== 'manager') abort(403, 'เฉพาะหัวหน้างานเท่านั้น');

        $request->validate(['status' => 'required|in:approved,rejected']);
        $leave->update(['status' => $request->status]);

        if ($request->status === 'approved') {
            $leave->user->decrement('remaining_leave_days', $leave->total_days);
        }

        return back()->with('success', 'อัปเดตสถานะเรียบร้อยแล้ว');
    }
    public function destroy(LeaveRequest $leaveRequest)
{
    // บล็อกถ้าไม่ใช่ manager
    if (auth()->user()->role !== 'manager') {
        abort(403, 'เฉพาะ Manager เท่านั้นที่สามารถลบรายการได้');
    }

    $leaveRequest->delete();

    return redirect()->route('leave.index')->with('success', 'ลบรายการลาเรียบร้อยแล้ว');
}
}