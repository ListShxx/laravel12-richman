<x-weight title="แก้ไขข้อมูล - Weight Tracker">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header text-dark p-4 border-0 rounded-top-4" style="background-color: #0dcaf0;">
                    <h4 class="mb-0 text-center fw-bold">อัปเดตข้อมูลน้ำหนัก</h4>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('weights.update', $weight->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-floating mb-4">
                            <input type="date" class="form-control @error('recorded_on') is-invalid @enderror" id="recorded_on" name="recorded_on" value="{{ old('recorded_on', $weight->recorded_on) }}">
                            <label for="recorded_on">วันที่บันทึก</label>
                            @error('recorded_on')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-4">
                            <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', $weight->weight) }}" placeholder="ระบุน้ำหนัก">
                            <label for="weight">น้ำหนัก (กิโลกรัม)</label>
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-info btn-lg rounded-pill fw-bold shadow-sm text-dark">บันทึกการเปลี่ยนแปลง</button>
                            <a href="{{ route('weights.index') }}" class="btn btn-light btn-lg rounded-pill text-secondary">ย้อนกลับ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-weight>