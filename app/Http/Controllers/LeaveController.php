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
    // ตรวจสอบว่าผู้ใช้ล็อกอินอยู่หรือไม่ ถ้ายังไม่ล็อกอินให้แสดงหน้า Welcome
    if (!auth()->check()) {
        return view('leave.welcome');
    }

    $user = auth()->user();

    // ดึงรายการการลาตามสิทธิ์
    if ($user->role === 'manager') {
        $leaves = LeaveRequest::with('user')->latest()->get();
    } else {
        $leaves = LeaveRequest::where('user_id', $user->id)->latest()->get();
    }

    // คำนวณวันลาคงเหลือ
    $usedDays = LeaveRequest::where('user_id', $user->id)
        ->whereIn('status', ['approved', 'APPROVED'])
        ->sum('total_days');

    $totalQuota = 15;
    $remainingDays = max(0, $totalQuota - $usedDays);

    return view('leave.index', compact('leaves', 'remainingDays'));
}

    // บันทึกการขอลางาน
    public function store(Request $request)
{
    $request->validate([
        'start_date' => 'required|date',
        'end_date'   => 'required|date|after_or_equal:start_date',
        'reason'     => 'required|string',
    ]);

    $start = \Carbon\Carbon::parse($request->start_date);
    $end   = \Carbon\Carbon::parse($request->end_date);
    $days  = $start->diffInDays($end) + 1;

    LeaveRequest::create([
        'user_id'    => auth()->id(),
        'start_date' => $request->start_date,
        'end_date'   => $request->end_date,
        'total_days' => $days,
        'days'       => $days,
        'reason'     => $request->reason,
        'status'     => 'pending',
    ]);

    return redirect()->route('leave.index')->with('success', 'ส่งคำขอลาสำเร็จ');
}

    // อนุมัติ/ปฏิเสธใบลา
    public function updateStatus(Request $request, LeaveRequest $leaveRequest)
{
    if (auth()->user()->role !== 'manager') {
        abort(403, 'เฉพาะ Manager เท่านั้นที่สามารถอนุมัติการลาได้');
    }

    $request->validate([
        'status' => 'required|in:approved,rejected,pending,APPROVED,REJECTED,PENDING',
    ]);

    // แปลงค่าเป็นตัวพิมพ์เล็กก่อนบันทึกลง SQLite
    $leaveRequest->update([
        'status' => strtolower($request->status),
    ]);

    return redirect()->route('leave.index')->with('success', 'อัปเดตสถานะการลาเรียบร้อยแล้ว');
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