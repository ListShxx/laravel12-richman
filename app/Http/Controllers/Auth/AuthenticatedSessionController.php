<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    // 1. ถ้ามีการส่งค่า redirect มากับฟอร์ม ให้ส่งไปหน้านั้นทันที (เช่น /about-me)
    if ($request->filled('redirect')) {
        return redirect($request->input('redirect'));
    }

    // 2. ถ้ามาจากหน้าที่ต้องใช้ Auth (intended) ให้กลับไปหน้านั้น ถ้าไม่มีค่อยไปหน้า /leave
    return redirect()->intended(route('leave.index'));
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
{
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    // เปลี่ยนจุดหมายปลายทางหลังออกจากระบบเป็น /leave
    return redirect('/leave');
}
}
