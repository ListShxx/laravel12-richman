<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me</title>
    <!-- เรียกใช้ Bootstrap 5 ผ่าน CDN เพื่อความรวดเร็วและสวยงาม -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <!-- ส่วนที่ 1: ข้อมูลส่วนบุคคล -->
                <div class="card shadow-sm mb-4 border-0 rounded-4">
                    <div class="card-body text-center p-5">
                        <!-- รูปภาพ: เรียกใช้จาก public/images/profile.jpg -->
                        <img src="{{ asset('images/profile.png') }}" alt="My Profile" 
                             class="rounded-circle mb-3 shadow" 
                             width="150" height="150" style="object-fit: cover;">
                        
                        <h3 class="fw-bold">นายพงศกร ศรีผา</h3>
                        <p class="text-muted fs-5">รหัสนักศึกษา : 68222420009</p>

                        <!-- EP08 Auth: ปุ่ม Login & Logout -->
                        <div class="mt-4">
                            @guest
                                <!-- กรณีที่ยังไม่ได้เข้าสู่ระบบ -->
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('login', ['redirect' => '/about-me']) }}" class="btn btn-primary px-4 rounded-pill shadow-sm">
                                        Login
                                    </a>
                                    <a href="/register" class="btn btn-outline-primary px-4 rounded-pill shadow-sm">
                                        Register
                                    </a>
                                </div>
                                <p class="text-danger mt-3 small">จุ๊บๆ</p>
                            @else
                                <!-- กรณีเข้าสู่ระบบแล้ว: แสดงชื่อผู้ใช้คู่กับปุ่ม Logout -->
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <span class="badge bg-success fs-6 px-3 py-2 rounded-pill shadow-sm">
                                        เข้าสู่ระบบแล้วในชื่อ: {{ Auth::user()->name }}
                                    </span>
                                    
                                    <!-- ปุ่ม Logout -->
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger px-3 py-1 rounded-pill shadow-sm fs-6">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>

                <!-- ส่วนที่ 2: ลิงก์งานที่เคยทำ -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-dark text-white rounded-top-4 py-3">
                        <h5 class="mb-0 fw-bold">📁 ผลงานที่เคยทำ (My Projects)</h5>
                    </div>
                    <div class="list-group list-group-flush rounded-bottom-4">
                        
                        <!-- EP02 Hero -->
                        <a href="/gallery" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                            <div>
                                <h6 class="mb-0 fw-bold">Hero Gallery</h6>
                                <small class="text-muted"></small>
                            </div>
                            <span class="badge bg-info text-dark rounded-pill">คลิกเพื่อดูงาน</span>
                        </a>

                        <!-- EP03 Active Bootstrap -->
                        <a href="/active/index" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                            <div>
                                <h6 class="mb-0 fw-bold">Active Bootstrap</h6>
                                <small class="text-muted"></small>
                            </div>
                            <span class="badge bg-info text-dark rounded-pill">คลิกเพื่อดูงาน</span>
                        </a>

                        <!-- EP07 Weight -->
                        <a href="/weights" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                            <div>
                                <h6 class="mb-0 fw-bold">Weight</h6>
                                <small class="text-muted"></small>
                            </div>
                            <span class="badge bg-warning text-dark rounded-pill">
                                ล็อกอินก่อนเข้า
                            </span>
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>