<x-weight title="เพิ่มข้อมูลใหม่ - Weight Tracker">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header text-white p-4 border-0 rounded-top-4" style="background-color: #198754;">
                    <h4 class="mb-0 text-center fw-bold">เพิ่มสถิติน้ำหนัก</h4>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('weights.store') }}" method="POST">
                        @csrf
                        
                        <!-- Floating Label สำหรับวันที่ -->
                        <div class="form-floating mb-4">
                            <input type="date" class="form-control @error('recorded_on') is-invalid @enderror" id="recorded_on" name="recorded_on" value="{{ old('recorded_on', date('Y-m-d')) }}">
                            <label for="recorded_on">วันที่บันทึก</label>
                            @error('recorded_on')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Floating Label สำหรับน้ำหนัก -->
                        <div class="form-floating mb-4">
                            <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight') }}" placeholder="ระบุน้ำหนัก">
                            <label for="weight">น้ำหนัก (กิโลกรัม)</label>
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- ปุ่มกดแบบยาวเต็มบล็อก -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm">บันทึกข้อมูล</button>
                            <a href="{{ route('weights.index') }}" class="btn btn-light btn-lg rounded-pill text-secondary">ย้อนกลับ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-weight>