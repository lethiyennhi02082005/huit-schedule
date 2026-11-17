<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập — HUIT Schedule Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-slate-100 flex items-center justify-center p-4 sm:p-6 relative overflow-x-hidden">

    <!-- HIỆU ỨNG ÁNH SÁNG NỀN -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-12 bg-white/10 backdrop-blur-xl border border-white/15 rounded-3xl shadow-2xl overflow-hidden z-10">

        <!-- CỘT TRÁI: GIỚI THIỆU & THƯƠNG HIỆU HUIT (5 CỘT) -->
        <div class="lg:col-span-5 bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 p-8 sm:p-10 flex flex-col justify-between text-white relative overflow-hidden">
            <div class="absolute -right-16 -top-16 w-56 h-56 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>

            <div>
                <!-- LOGO & BADGE -->
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-white text-blue-800 flex items-center justify-center text-xl font-extrabold shadow-lg shadow-blue-900/40">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-lg tracking-wide">HUIT SCHEDULE</div>
                        <div class="text-xs text-blue-200 tracking-wider font-medium">HUBLAB · ĐA CƠ SỞ</div>
                    </div>
                </div>

                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 border border-white/20 text-xs font-semibold text-blue-100 mb-6 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Hệ thống Phân lịch Thông minh
                </div>

                <h1 class="text-2xl sm:text-3xl font-bold leading-tight mb-4">
                    Tối ưu thời gian di chuyển giữa các cơ sở
                </h1>
                <p class="text-blue-100/80 text-sm leading-relaxed mb-6">
                    Hỗ trợ Phòng Đào tạo phân bổ tiết dạy khoa học, tự động phát hiện trùng lịch, phòng học và gợi ý giảng viên có chuyên môn phù hợp.
                </p>

                <!-- 3 ĐIỂM NỔI BẬT -->
                <div class="space-y-3 text-xs sm:text-sm">
                    <div class="flex items-center gap-3 text-blue-100/90">
                        <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center text-emerald-300 flex-shrink-0 text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <span>Tránh chồng chéo & khoảng trống chết giữa các ca</span>
                    </div>
                    <div class="flex items-center gap-3 text-blue-100/90">
                        <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center text-emerald-300 flex-shrink-0 text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <span>Cổng thông tin tra cứu lịch cá nhân trực tuyến</span>
                    </div>
                    <div class="flex items-center gap-3 text-blue-100/90">
                        <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center text-emerald-300 flex-shrink-0 text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <span>Thống kê phân bổ theo thời gian thực (Chart.js)</span>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-white/15 text-xs text-blue-200/80 mt-8">
                Đồ án: <span class="font-semibold text-white">Lê Thị Yến Nhi</span> · MSSV: <span class="font-semibold text-white">2001230614</span>
            </div>
        </div>

        <!-- CỘT PHẢI: FORM ĐĂNG NHẬP & QUICK LOGIN (7 CỘT) -->
        <div class="lg:col-span-7 bg-white text-slate-800 p-8 sm:p-10 flex flex-col justify-between">
            <div>
                <div class="mb-6">
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Đăng nhập hệ thống</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Vui lòng đăng nhập tài khoản Phòng Đào tạo hoặc Giảng viên</p>
                </div>

                <!-- THÔNG BÁO LỖI -->
                @if ($errors->any())
                    <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs sm:text-sm flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-exclamation text-red-500 text-base"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs sm:text-sm flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <!-- KHU VỰC ĐĂNG NHẬP NHANH 1 CHẠM (TIỆN LỢI CHO THẦY CÔ CHẤM ĐIỂM) -->
                <div class="mb-6 bg-slate-50 border border-slate-200/80 rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-2.5">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                            <i class="fa-solid fa-bolt text-amber-500"></i> Đăng nhập nhanh thử nghiệm:
                        </span>
                        <span class="text-[11px] text-slate-400 font-medium">Bấm để tự điền</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        <button type="button" onclick="quickLogin('admin@huit.edu.vn', '12345678')" class="flex items-center gap-2.5 p-2.5 rounded-xl bg-white border border-slate-200 hover:border-blue-500 hover:bg-blue-50/50 hover:shadow-sm text-left transition group">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-sm font-bold group-hover:scale-105 transition">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                            <div class="overflow-hidden">
                                <div class="text-xs font-bold text-slate-800">Phòng Đào Tạo</div>
                                <div class="text-[11px] text-slate-400 truncate">admin@huit.edu.vn</div>
                            </div>
                        </button>

                        <button type="button" onclick="quickLogin('gv1@huit.edu.vn', '12345678')" class="flex items-center gap-2.5 p-2.5 rounded-xl bg-white border border-slate-200 hover:border-emerald-500 hover:bg-emerald-50/50 hover:shadow-sm text-left transition group">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold group-hover:scale-105 transition">
                                <i class="fa-solid fa-chalkboard-user"></i>
                            </div>
                            <div class="overflow-hidden">
                                <div class="text-xs font-bold text-slate-800">Giảng Viên Mẫu</div>
                                <div class="text-[11px] text-slate-400 truncate">gv1@huit.edu.vn</div>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- FORM ĐĂNG NHẬP CHÍNH -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-bold uppercase text-slate-600 mb-1.5 tracking-wider">
                            Địa chỉ Email
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                <i class="fa-regular fa-envelope"></i>
                            </span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition outline-none font-medium"
                                placeholder="name@huit.edu.vn">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold uppercase text-slate-600 tracking-wider">
                                Mật khẩu
                            </label>
                            <span class="text-xs text-slate-400">(Mặc định: 12345678)</span>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input id="password" type="password" name="password" required
                                class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition outline-none font-medium"
                                placeholder="••••••••">
                            <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600">
                                <i id="eyeIcon" class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded text-blue-600 border-slate-300 focus:ring-blue-500">
                            <span class="ml-2 text-slate-600 font-medium">Ghi nhớ đăng nhập</span>
                        </label>
                        <span class="text-blue-600 hover:underline cursor-pointer">Cần trợ giúp?</span>
                    </div>

                    <button type="submit" class="w-full mt-2 py-3 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition duration-200 flex items-center justify-center gap-2 group">
                        <span>Đăng nhập vào hệ thống</span>
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition duration-200"></i>
                    </button>
                </form>
            </div>

            <div class="mt-8 pt-4 border-t border-slate-100 text-center text-xs text-slate-400">
                Hệ thống Quản lý Giảng dạy Đa cơ sở · Đại học Công Thương TP.HCM (HUIT)
            </div>
        </div>

    </div>

    <script>
        function quickLogin(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }

        function togglePasswordVisibility() {
            const pwdInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                pwdInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
