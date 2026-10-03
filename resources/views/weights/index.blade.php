<x-weight title="แดชบอร์ดน้ำหนัก - Weight Tracker">
    <div class="row mb-4 align-items-center mt-3">
        <div class="col-md-8">
            <h2 class="fw-bold" style="color: #198754;">📊 สถิติน้ำหนักของฉัน</h2>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('weights.create') }}" class="btn btn-outline-success rounded-pill px-4 shadow-sm">
                + เพิ่มข้อมูลใหม่
            </a>
        </div>
    </div>

    <!-- ส่วนแสดง Google Chart (ใส่ในกล่องขอบมน) -->
    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body p-4 bg-white rounded-4">
            @if($weights->count() > 0)
                <div id="curve_chart" style="width: 100%; height: 400px;"></div>
            @else
                <div class="text-center py-5 text-muted">
                    <h5 class="mb-0">ยังไม่มีข้อมูลสำหรับแสดงกราฟ</h5>
                </div>
            @endif
        </div>
    </div>

    <!-- ส่วนแสดงตารางข้อมูล (โหมดมืด) -->
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle text-center">
                <thead class="text-white" style="background-color: #212529;">
                    <tr>
                        <th class="py-3">วันที่บันทึก</th>
                        <th class="py-3">น้ำหนัก (กิโลกรัม)</th>
                        <th class="py-3">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($weights as $item)
                        <tr>
                            <td class="py-3">{{ $item->recorded_on }}</td>
                            <td class="py-3 fw-bold text-success fs-5">{{ $item->weight }}</td>
                            <td class="py-3">
                                <a href="{{ route('weights.edit', $item->id) }}" class="btn btn-sm btn-info text-dark rounded-pill px-3 fw-bold">แก้ไข</a>
                                <form action="{{ route('weights.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบข้อมูลนี้?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">ลบ</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-5 text-secondary">ไม่มีประวัติน้ำหนัก เริ่มต้นบันทึกกันเลย!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script สำหรับวาดกราฟ Google Chart -->
    @if($weights->count() > 0)
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  // แก้ไขเครื่องหมายตรง : ['corechart'] ให้ถูกต้อง
  google.charts.load('current', {'packages': ['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable(@json($chartData));
    
    var options = {
      title: 'กราฟแสดงแนวโน้มน้ำหนัก',
      curveType: 'function',
      legend: { position: 'bottom' },
      pointSize: 7,
      colors: ['#198754'], // เปลี่ยนเส้นกราฟเป็นสีเขียว
      chartArea: { width: '85%', height: '70%' }
    };
    
    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
    chart.draw(data, options);
  }
</script>
    @endif
</x-weight>