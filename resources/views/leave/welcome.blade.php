<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบลางาน - ยินดีต้อนรับ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-xl shadow-md p-8 text-center border border-gray-200">
        <!-- ไอคอน / หัวข้อ -->
        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">
            📋
        </div>
        
        <h1 class="text-2xl font-bold text-gray-800 mb-2">ระบบจัดการการลา</h1>
        <p class="text-gray-600 text-sm mb-6">
            ยินดีต้อนรับสู่ระบบลางาน กรุณาเข้าสู่ระบบเพื่อยื่นคำขอลา หรือสมัครสมาชิกสำหรับผู้ใช้งานใหม่
        </p>

        <!-- ปุ่มทางเลือก -->
        <div class="space-y-3">
            <a href="{{ route('login') }}" 
               class="block w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">
                เข้าสู่ระบบ (Login)
            </a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" 
                   class="block w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition shadow-sm">
                    สมัครสมาชิก (Register)
                </a>
            @endif
        </div>
    </div>
</body>
</html>