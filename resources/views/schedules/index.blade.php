<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HUIT Schedule Hub — Quản lý Phân lịch Giảng dạy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans antialiased text-slate-800 overflow-hidden">

<!-- KHUNG TỔNG CAO ĐÚNG 100% MÀN HÌNH -->
<div class="h-screen flex overflow-hidden">

    <!-- LỚP PHỦ MỜ KHI MỞ SIDEBAR TRÊN MÀN HÌNH NHỎ -->
    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-20 hidden md:hidden"></div>

    <!-- SIDEBAR TRÁI CỐ ĐỊNH + CÓ THỂ ẨN/HIỆN -->
    <aside id="sidebar" class="fixed md:static inset-y-0 left-0 z-30 w-64 bg-slate-900 text-slate-200 flex-shrink-0 flex flex-col justify-between h-full transition-all duration-300 -translate-x-full md:translate-x-0 overflow-hidden">
        <div class="w-64">
            <div class="h-16 flex items-center justify-between px-6 bg-slate-950 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <div class="font-bold text-white tracking-wide text-sm">HUIT SCHEDULE</div>
                        <div class="text-[11px] text-slate-400">Quản lý Đa cơ sở</div>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="md:hidden text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <nav class="p-4 space-y-1.5 text-sm">
                <div class="text-xs uppercase text-slate-500 font-semibold px-3 py-2">Hệ thống</div>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-blue-600 text-white font-medium">
                    <i class="fa-solid fa-gauge-high w-4"></i> Tổng quan & Phân lịch
                </a>
                @if($user->role === 'admin')
                <a href="#form-phan-lich" onclick="scrollToSection(event, 'form-phan-lich')" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                    <i class="fa-solid fa-plus-circle w-4"></i> Thêm lịch dạy mới
                </a>
                <a href="#bo-loc-lich" onclick="scrollToSection(event, 'bo-loc-lich')" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                    <i class="fa-solid fa-filter w-4"></i> Tra cứu & Thống kê
                </a>
                @endif
                <a href="#bang-tkb" onclick="scrollToSection(event, 'bang-tkb')" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                    <i class="fa-solid fa-table-list w-4"></i> Thời khóa biểu chi tiết
                </a>
            </nav>
        </div>

        <div class="w-64 p-4 border-t border-slate-800 bg-slate-950/50">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center font-bold uppercase">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-semibold text-white truncate">{{ $user->name }}</p>
                    <p class="text-xs text-slate-400">{{ $user->role === 'admin' ? 'Phòng Đào Tạo' : 'Giảng viên' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-lg bg-slate-800 hover:bg-red-600 text-slate-200 hover:text-white text-xs font-medium transition">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất hệ thống
                </button>
            </form>
        </div>
    </aside>

    <!-- KHU VỰC NỘI DUNG BÊN PHẢI (CUỘN ĐỘC LẬP) -->
    <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
        <!-- TOPBAR CỐ ĐỊNH -->
        <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between flex-shrink-0 z-10">
            <div class="flex items-center gap-3">
                <!-- NÚT BẤM ĐÓNG / MỞ SIDEBAR -->
                <button onclick="toggleSidebar()" title="Ẩn / Hiện thanh menu" class="w-9 h-9 rounded-lg border border-slate-200 hover:bg-slate-100 text-slate-600 flex items-center justify-center transition">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <h1 class="text-lg font-bold text-slate-800 truncate">
                    {{ $user->role === 'admin' ? 'Bảng điều khiển Phân lịch Giảng dạy' : 'Cổng thông tin Lịch dạy Cá nhân' }}
                </h1>
                <span class="hidden sm:inline-block px-2.5 py-0.5 text-xs font-medium rounded-full {{ $user->role === 'admin' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700' }}">
                    {{ $user->role === 'admin' ? 'Quản trị viên' : 'Giảng viên HUIT' }}
                </span>
            </div>
            <div class="flex items-center gap-4 text-sm text-slate-500">
                <span class="hidden sm:inline"><i class="fa-regular fa-clock mr-1"></i> Học kỳ I (2026 - 2027)</span>
            </div>
        </header>

        <!-- VÙNG CUỘN RIÊNG CỦA NỘI DUNG CHÍNH -->
        <main id="mainContent" class="flex-1 overflow-y-auto p-6 scroll-smooth">
            <div class="space-y-6 max-w-7xl w-full mx-auto pb-10">
                <!-- THÔNG BÁO -->
                @if(session('success'))
                    <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl shadow-sm">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <span class="font-medium text-sm">{{ session('success') }}</span>
                    </div>
                @endif
                @if($errors->any())
                    <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl shadow-sm">
                        <i class="fa-solid fa-triangle-exclamation text-red-600 text-lg"></i>
                        <span class="font-medium text-sm">{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- 4 THẺ KPI THỐNG KÊ NHANH -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase">Tổng số ca dạy</p>
                            <p class="text-2xl font-bold text-slate-800 mt-1">{{ $schedules->count() }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase">Cơ sở đào tạo</p>
                            <p class="text-2xl font-bold text-slate-800 mt-1">{{ $branches->count() }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase">Đội ngũ Giảng viên</p>
                            <p class="text-2xl font-bold text-slate-800 mt-1">{{ $teachers->count() }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase">Trạng thái hệ thống</p>
                            <p class="text-sm font-bold text-emerald-600 mt-2"><i class="fa-solid fa-circle text-[8px] mr-1"></i> Tối ưu lịch trống</p>
                        </div>
                        <div class="w-11 h-11 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </div>
                    </div>
                </div>

                @if($user->role === 'admin')
                <!-- HÀNG 2: FORM PHÂN LỊCH (2/3) + BIỂU ĐỒ PHÂN BỔ (1/3) -->
                <div id="form-phan-lich" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- FORM PHÂN LỊCH THÔNG MINH -->
                    <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/70 flex items-center justify-between">
                            <h2 class="font-bold text-slate-800 flex items-center gap-2">
                                <i class="fa-solid fa-calendar-plus text-blue-600"></i>
                                Phân lịch Giảng dạy & Gợi ý Giảng viên Trống lịch
                            </h2>
                            <span class="text-xs text-slate-500">Tự động kiểm tra trùng lịch & di chuyển</span>
                        </div>

                        <form action="{{ route('schedules.store') }}" method="POST" class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Cơ sở giảng dạy</label>
                                <select name="branch_id" id="branch_id" onchange="fetchSuggestions()" class="w-full rounded-lg border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                                    @foreach($branches as $b)
                                        <option value="{{ $b->id }}">{{ $b->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Thứ</label>
                                    <select name="day_of_week" id="day_of_week" onchange="fetchSuggestions()" class="w-full rounded-lg border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        @for($d = 2; $d <= 7; $d++)
                                            <option value="{{ $d }}">Thứ {{ $d }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Ca / Tiết học</label>
                                    <select name="shift_or_periods" id="shift_or_periods" onchange="fetchSuggestions()" class="w-full rounded-lg border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="Sáng (Tiết 1-3)">Sáng (Tiết 1-3)</option>
                                        <option value="Sáng (Tiết 4-6)">Sáng (Tiết 4-6)</option>
                                        <option value="Chiều (Tiết 7-9)">Chiều (Tiết 7-9)</option>
                                        <option value="Chiều (Tiết 10-12)">Chiều (Tiết 10-12)</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Lọc Chuyên môn (Gợi ý)</label>
                                <input type="text" id="expertise" onkeyup="fetchSuggestions()" placeholder="VD: Mã nguồn mở, CSDL..." class="w-full rounded-lg border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div class="grid grid-cols-3 gap-3">
                                <div class="col-span-2">
                                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Tên Học phần</label>
                                    <input type="text" name="subject_name" required placeholder="VD: Lập trình MNM" class="w-full rounded-lg border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Phòng</label>
                                    <input type="text" name="room" required placeholder="PM.03" class="w-full rounded-lg border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>

                            <div class="md:col-span-2 bg-slate-50 p-3.5 rounded-lg border border-slate-200">
                                <label class="block text-xs font-bold text-emerald-700 uppercase mb-1">
                                    <i class="fa-solid fa-user-check mr-1"></i> Giảng viên phù hợp (Đã lọc trùng lịch):
                                </label>
                                <select name="teacher_id" id="teacher_select" required class="w-full rounded-lg border-emerald-400 bg-white text-sm focus:border-emerald-500 focus:ring-emerald-500">
                                    @foreach($teachers as $t)
                                        <option value="{{ $t->id }}">{{ $t->full_name }} ({{ $t->expertise }})</option>
                                    @endforeach
                                </select>
                                <p id="travel_note" class="text-xs text-amber-600 font-medium mt-1.5 flex items-center gap-1"></p>
                            </div>

                            <div class="md:col-span-2 flex justify-end pt-1">
                                <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-2.5 rounded-lg shadow-sm transition">
                                    <i class="fa-solid fa-floppy-disk"></i> Lưu Phân Lịch Giảng Dạy
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- BIỂU ĐỒ PHÂN BỔ THU GỌN -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
                        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/70">
                            <h2 class="font-bold text-slate-800 flex items-center gap-2">
                                <i class="fa-solid fa-chart-pie text-blue-600"></i>
                                Phân bổ theo Cơ sở
                            </h2>
                        </div>
                        <div class="p-6 flex-1 flex flex-col items-center justify-center">
                            <div class="relative w-full" style="height: 220px;">
                                <canvas id="branchChart"></canvas>
                            </div>
                        </div>
                        <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 text-xs text-slate-500 text-center">
                            Tỷ trọng số ca giảng dạy tại các cơ sở HUIT
                        </div>
                    </div>
                </div>
                @endif

                <!-- HÀNG 3: BẢNG THỜI KHÓA BIỂU + THANH LỌC TÍCH HỢP -->
                <div id="bang-tkb" class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div id="bo-loc-lich" class="px-6 py-4 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-slate-50/70">
                        <div>
                            <h2 class="font-bold text-slate-800 text-base flex items-center gap-2">
                                <i class="fa-solid fa-table text-blue-600"></i>
                                Danh sách Thời khóa biểu ({{ $schedules->count() }} ca dạy)
                            </h2>
                        </div>

                        @if($user->role === 'admin')
                        <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap items-center gap-2">
                            <select name="branch_id" class="rounded-lg border-slate-300 text-xs py-2">
                                <option value="">-- Tất cả Cơ sở --</option>
                                @foreach($branches as $b)
                                    <option value="{{ $b->id }}" {{ request('branch_id') == $b->id ? 'selected' : '' }}>{{ $b->branch_name }}</option>
                                @endforeach
                            </select>
                            <select name="teacher_id" class="rounded-lg border-slate-300 text-xs py-2">
                                <option value="">-- Tất cả Giảng viên --</option>
                                @foreach($teachers as $t)
                                    <option value="{{ $t->id }}" {{ request('teacher_id') == $t->id ? 'selected' : '' }}>{{ $t->full_name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white text-xs font-medium px-3.5 py-2 rounded-lg transition">
                                <i class="fa-solid fa-magnifying-glass mr-1"></i> Lọc
                            </button>
                            <a href="{{ route('dashboard') }}" class="bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 text-xs font-medium px-3 py-2 rounded-lg transition">
                                Đặt lại
                            </a>
                        </form>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="bg-slate-100/80 text-slate-600 uppercase text-xs border-b border-slate-200">
                                    <th class="py-3.5 px-4 font-semibold">Thứ</th>
                                    <th class="py-3.5 px-4 font-semibold">Ca / Tiết học</th>
                                    <th class="py-3.5 px-4 font-semibold">Học phần</th>
                                    <th class="py-3.5 px-4 font-semibold">Giảng viên</th>
                                    <th class="py-3.5 px-4 font-semibold">Cơ sở giảng dạy</th>
                                    <th class="py-3.5 px-4 font-semibold">Phòng</th>
                                    @if($user->role === 'admin')
                                    <th class="py-3.5 px-4 font-semibold text-right">Thao tác</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($schedules as $item)
                                <tr class="hover:bg-blue-50/40 transition">
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 font-semibold text-xs">
                                            Thứ {{ $item->day_of_week }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap text-slate-600">{{ $item->shift_or_periods }}</td>
                                    <td class="py-3.5 px-4 font-semibold text-blue-700">{{ $item->subject_name }}</td>
                                    <td class="py-3.5 px-4">
                                        <div class="font-medium text-slate-800">{{ $item->teacher->full_name }}</div>
                                        <div class="text-xs text-slate-400">{{ $item->teacher->expertise }}</div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="font-medium text-slate-700">{{ $item->branch->branch_name }}</div>
                                        <div class="text-xs text-slate-400">{{ $item->branch->address }}</div>
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-700 border border-amber-200 font-mono text-xs font-semibold">
                                            {{ $item->room }}
                                        </span>
                                    </td>
                                    @if($user->role === 'admin')
                                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                        <form action="{{ route('schedules.destroy', $item) }}" method="POST" onsubmit="return confirm('Xác nhận xóa lịch dạy này?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-2.5 py-1 rounded-md text-xs font-medium transition">
                                                <i class="fa-solid fa-trash-can mr-1"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-slate-400">
                                        <i class="fa-regular fa-folder-open text-2xl mb-2 block"></i>
                                        Chưa có dữ liệu lịch dạy phù hợp.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    // 1. Đóng / mở Sidebar mượt mà trên cả Desktop & Mobile
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const isDesktop = window.innerWidth >= 768;

        if (isDesktop) {
            // Trên máy tính: thu gọn chiều rộng về 0 hoặc mở lại 64
            if (sidebar.classList.contains('md:w-0')) {
                sidebar.classList.remove('md:w-0');
                sidebar.classList.add('w-64');
            } else {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('md:w-0');
            }
        } else {
            // Trên màn hình nhỏ: trượt ra/vào
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    }

    // 2. Cuộn mượt riêng vùng nội dung bên phải mà không làm trôi Sidebar
    function scrollToSection(event, sectionId) {
        event.preventDefault();
        const container = document.getElementById('mainContent');
        const target = document.getElementById(sectionId);
        if (container && target) {
            container.scrollTo({
                top: target.offsetTop - 80,
                behavior: 'smooth'
            });
        }
        if (window.innerWidth < 768) {
            toggleSidebar();
        }
    }

    // 3. Gọi API gợi ý giảng viên
    const suggestApiUrl = "{{ url('/api/suggest-teachers') }}";

    function fetchSuggestions() {
        const branchEl = document.getElementById('branch_id');
        if (!branchEl) return;

        const branchId = branchEl.value;
        const day = document.getElementById('day_of_week').value;
        const shift = document.getElementById('shift_or_periods').value;
        const expertise = document.getElementById('expertise').value;

        fetch(`${suggestApiUrl}?branch_id=${branchId}&day_of_week=${day}&shift_or_periods=${encodeURIComponent(shift)}&expertise=${encodeURIComponent(expertise)}`)
            .then(res => res.json())
            .then(data => {
                const select = document.getElementById('teacher_select');
                const note = document.getElementById('travel_note');
                select.innerHTML = '';
                if (data.length === 0) {
                    select.innerHTML = '<option value="">Không có giảng viên rảnh phù hợp!</option>';
                    note.textContent = '';
                    return;
                }
                data.forEach((t, idx) => {
                    const opt = document.createElement('option');
                    opt.value = t.id;
                    opt.textContent = `${t.full_name} — [${t.expertise}] (${t.travel_warning})`;
                    select.appendChild(opt);
                    if (idx === 0) {
                        note.innerHTML = `<i class="fa-solid fa-route"></i> ${t.travel_warning}`;
                    }
                });
            });
    }
</script>

@if($user->role === 'admin')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        fetchSuggestions();
        const labels = JSON.parse('{!! json_encode($branchStats->pluck("branch_name")) !!}');
        const counts = JSON.parse('{!! json_encode($branchStats->pluck("schedules_count")) !!}');

        new Chart(document.getElementById('branchChart'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: counts,
                    backgroundColor: ['#2563eb', '#10b981', '#f59e0b'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            font: { size: 11 }
                        }
                    }
                }
            }
        });
    });
</script>
@endif

</body>
</html>