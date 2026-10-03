<?php

namespace App\Http\Controllers;
use App\Models\Weight;
use Illuminate\Http\Request;

class WeightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // 2. ดึงข้อมูลน้ำหนักจากฐานข้อมูล (สมมติว่าเรียงตามวันที่บันทึก)
        // ถ้าต้องการกรองเฉพาะ User ที่ Login ให้ใช้: Weight::where('user_id', auth()->id())->get();
        $weights = Weight::orderBy('recorded_on', 'asc')->get();

        // 3. เตรียมข้อมูลสำหรับทำกราฟ Google Chart
        $chartData = [
            ['วันที่', 'น้ำหนัก'] // แถวแรกคือหัวคอลัมน์ของกราฟ
        ];

        // วนลูปเอาข้อมูลมาใส่ในรูปแบบที่กราฟต้องการ
        foreach ($weights as $item) {
            $chartData[] = [
                $item->recorded_on, 
                (float)$item->weight // แปลงน้ำหนักเป็นตัวเลข
            ];
        }

        // 4. Return View พร้อมส่งข้อมูลไปให้หน้าจอ
        // (สมมติว่าไฟล์ blade ของคุณชื่อ resources/views/weights/index.blade.php)
        return view('weights.index', compact('weights', 'chartData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('weights.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // 1. ตรวจสอบความถูกต้องของข้อมูลที่ส่งมา
        $request->validate([
            'recorded_on' => 'required|date',
            'weight' => 'required|numeric',
        ]);

        // 2. สร้างข้อมูลใหม่และบันทึกลงฐานข้อมูล
        $weight = new Weight();
        $weight->recorded_on = $request->recorded_on;
        $weight->weight = $request->weight;
        
        // หากในตารางของคุณมีการเก็บ ID ของผู้ใช้ด้วย ให้เอาคอมเมนต์บรรทัดล่างนี้ออกครับ
        $weight->user_id = auth()->id(); 

        $weight->save();

        // 3. ย้ายกลับไปที่หน้า index พร้อมแจ้งเตือนว่าบันทึกสำเร็จ
        return redirect()->route('weights.index')->with('success', 'บันทึกข้อมูลน้ำหนักเรียบร้อยแล้ว!');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $weight = Weight::findOrFail($id);
        
        // ส่งข้อมูลที่หาเจอไปแสดงในหน้าฟอร์มแก้ไข
        return view('weights.edit', compact('weight'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. ตรวจสอบข้อมูลเหมือนตอนบันทึก
        $request->validate([
            'recorded_on' => 'required|date',
            'weight' => 'required|numeric',
        ]);

        // 2. ค้นหาข้อมูลเดิมและอัปเดตค่าใหม่
        $weight = Weight::findOrFail($id);
        $weight->recorded_on = $request->recorded_on;
        $weight->weight = $request->weight;
        $weight->save();

        // 3. ย้ายกลับไปที่หน้า index
        return redirect()->route('weights.index')->with('success', 'อัปเดตข้อมูลน้ำหนักเรียบร้อยแล้ว!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // ค้นหาข้อมูลที่ต้องการลบ แล้วสั่งลบ
        $weight = Weight::findOrFail($id);
        $weight->delete();

        // ย้ายกลับไปที่หน้า index
        return redirect()->route('weights.index')->with('success', 'ลบข้อมูลเรียบร้อยแล้ว!');
    }
}
