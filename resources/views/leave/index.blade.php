<!DOCTYPE html>
<html lang="en">
<head>
    <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm border mb-6">
    <div>
        <p class="text-gray-700 font-medium">
            ผู้ใช้งาน: <span class="font-bold">{{ auth()->user()->name }}</span> ({{ auth()->user()->role }})
        </p>
        <p class="text-blue-600 font-semibold">
            วันลาคงเหลือ: {{ auth()->user()->remaining_leave_days }} วัน
        </p>
    </div>

    <!-- ปุ่ม Logout -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" 
                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition shadow-sm">
            ออกจากระบบ
        </button>
    </form>
</div>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบลางาน</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">ระบบลางาน</h1>
        
        <div class="mb-4 bg-white p-4 rounded shadow">
            <p>ผู้ใช้งาน: {{ auth()->user()->name }} ({{ auth()->user()->role }})</p>
            <p class="text-lg font-bold text-blue-600">วันลาคงเหลือ: {{ auth()->user()->remaining_leave_days }} วัน</p>
        </div>

        @if(session('success')) <div class="bg-green-200 text-green-800 p-3 mb-4 rounded">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="bg-red-200 text-red-800 p-3 mb-4 rounded">{{ session('error') }}</div> @endif

        <!-- ฟอร์มยื่นลา (สำหรับทุกคน) -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-lg font-bold mb-4">ยื่นขอลางาน</h3>
            <form action="{{ route('leave.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div><label>วันที่เริ่มลา</label><input type="date" name="start_date" class="border p-2 w-full rounded" required></div>
                    <div><label>ถึงวันที่</label><input type="date" name="end_date" class="border p-2 w-full rounded" required></div>
                </div>
                <div class="mb-4"><label>เหตุผล</label><textarea name="reason" class="border p-2 w-full rounded" required></textarea></div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">ส่งคำขอ</button>
            </form>
        </div>

        <!-- รายการใบลา -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-bold mb-4">ประวัติการลา</h3>
            <table class="w-full border-collapse border bg-white rounded-lg overflow-hidden shadow-sm">
    <thead>
        <tr class="bg-gray-100 border-b">
            <th class="p-3 border text-left">ชื่อ</th>
            <th class="p-3 border text-center">วันที่</th>
            <th class="p-3 border text-center">จำนวนวัน</th>
            <th class="p-3 border text-left">เหตุผล</th>
            <th class="p-3 border text-center">สถานะ</th>
            <th class="p-3 border text-center">จัดการ (สำหรับ Manager)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($leaves as $leave)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3 border">{{ $leave->user->name ?? $leave->name }}</td>
                <td class="p-3 border text-center">{{ $leave->start_date }} ถึง {{ $leave->end_date }}</td>
                <td class="p-3 border text-center">{{ $leave->days }}</td>
                <td class="p-3 border">{{ $leave->reason }}</td>
                <td class="p-3 border text-center">
                    @if($leave->status === 'APPROVED')
                        <span class="text-emerald-600 font-bold">APPROVED</span>
                    @elseif($leave->status === 'REJECTED')
                        <span class="text-red-600 font-bold">REJECTED</span>
                    @else
                        <span class="text-yellow-600 font-bold">PENDING</span>
                    @endif
                </td>
                <td class="p-3 text-center border">
                    {{-- แสดงปุ่มลบเฉพาะผู้ใช้งานที่เป็น Manager เท่านั้น --}}
                    @if(auth()->user()->role === 'manager')
                        <form action="{{ route('leave.destroy', $leave) }}" method="POST" class="inline-block" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบรายการลานี้?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded transition shadow-sm">
                                ลบ
                            </button>
                        </form>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
        </div>
    </div>
</body>
</html>