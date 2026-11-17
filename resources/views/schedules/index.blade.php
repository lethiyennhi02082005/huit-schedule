<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HUIT Schedule Hub — Quản lý & Phân lịch Giảng dạy Đa cơ sở</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            aside, header, #form-phan-lich, #bo-loc-lich, .no-print, #viewToggleContainer, #editModal { display: none !important; }
            main { overflow: visible !important; padding: 0 !important; }
            #bang-tkb { border: none !important; box-shadow: none !important; }
            body { background: white !important; color: black !important; }
        }
    </style>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800 overflow-hidden">

<div class="h-screen flex overflow-hidden">

    <!-- LỚP PHỦ MỜ KHI MỞ MENU MOBILE -->
    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-30 hidden md:hidden transition-opacity"></div>

    <!-- SIDEBAR BÊN TRÁI -->
    <aside id="sidebar" class="fixed md:static inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-200 flex-shrink-0 flex flex-col justify-between h-full transition-all duration-300 -translate-x-full md:translate-x-0 border-r border-slate-800/80 shadow-2xl md:shadow-none">
        <div class="w-64">
            <!-- BRAND HEADER -->
            <div class="h-16 flex items-center justify-between px-5 bg-slate-950/80 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white font-extrabold shadow-md shadow-blue-500/20">
                        <i class="fa-solid fa-graduation-cap text-lg"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-white tracking-wide text-sm leading-tight">HUIT SCHEDULE</div>
                        <div class="text-[10px] text-blue-400 font-semibold uppercase tracking-wider">Đa Cơ Sở Thông Minh</div>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="md:hidden w-8 h-8 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- NAVIGATION LINKS -->
            <nav class="p-3.5 space-y-1 text-sm">
                <div class="text-[10px] uppercase text-slate-400 font-bold px-3 py-2 tracking-wider">Bảng Điều Khiển</div>
                
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-md shadow-blue-600/20">
                    <i class="fa-solid fa-gauge-high w-4 text-center"></i>
                    <span>Tổng quan & Lịch dạy</span>
                </a>

                @if($user->role === 'admin')
                <div class="text-[10px] uppercase text-slate-400 font-bold px-3 pt-3 pb-1 tracking-wider">Quản Trị Đào Tạo</div>
                <a href="#form-phan-lich" onclick="scrollToSection(event, 'form-phan-lich')" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-800/80 hover:text-white transition font-medium">
                    <i class="fa-solid fa-calendar-plus w-4 text-center text-blue-400"></i>
                    <span>Thêm / Phân Lịch Mới</span>
                </a>
                <a href="#bo-loc-lich" onclick="scrollToSection(event, 'bo-loc-lich')" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-800/80 hover:text-white transition font-medium">
                    <i class="fa-solid fa-filter w-4 text-center text-amber-400"></i>
                    <span>Bộ lọc theo Cơ sở/GV</span>
                </a>
                @endif

                <div class="text-[10px] uppercase text-slate-400 font-bold px-3 pt-3 pb-1 tracking-wider">Thời Khóa Biểu</div>
                <button onclick="switchView('grid')" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-800/80 hover:text-white transition font-medium text-left">
                    <i class="fa-solid fa-calendar-week w-4 text-center text-amber-400"></i>
                    <span>Lưới TKB Tuần (Ma Trận)</span>
                </button>
                <button onclick="switchView('table')" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-800/80 hover:text-white transition font-medium text-left">
                    <i class="fa-solid fa-table-list w-4 text-center text-emerald-400"></i>
                    <span>Danh sách chi tiết</span>
                </button>

                <button onclick="window.print()" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-800/80 hover:text-white transition font-medium text-left">
                    <i class="fa-solid fa-print w-4 text-center text-purple-400"></i>
                    <span>In Thời Khóa Biểu</span>
                </button>
            </nav>
        </div>

        <!-- USER FOOTER -->
        <div class="w-64 p-4 border-t border-slate-800 bg-slate-950/60">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-500/30 to-indigo-500/20 border border-blue-400/30 text-blue-400 flex items-center justify-center font-bold uppercase text-sm">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div class="overflow-hidden flex-1">
                    <p class="text-xs font-bold text-white truncate">{{ $user->name }}</p>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full {{ $user->role === 'admin' ? 'bg-blue-400' : 'bg-emerald-400' }}"></span>
                        <p class="text-[11px] text-slate-400 font-medium">{{ $user->role === 'admin' ? 'Phòng Đào Tạo' : 'Giảng viên' }}</p>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-xl bg-slate-800/80 hover:bg-red-600 text-slate-300 hover:text-white text-xs font-semibold transition duration-150">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                </button>
            </form>
        </div>
    </aside>

    <!-- KHU VỰC NỘI DUNG CHÍNH (BÊN PHẢI) -->
    <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden bg-slate-100/60">
        
        <!-- TOPBAR CỐ ĐỊNH -->
        <header class="h-16 bg-white border-b border-slate-200/80 px-6 flex items-center justify-between flex-shrink-0 z-20 shadow-xs">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" title="Ẩn / Hiện thanh menu" class="w-9 h-9 rounded-xl border border-slate-200 hover:bg-slate-100 text-slate-600 flex items-center justify-center transition">
                    <i class="fa-solid fa-bars text-sm"></i>
                </button>

                <div>
                    <h1 class="text-base sm:text-lg font-extrabold text-slate-900 truncate tracking-tight">
                        {{ $user->role === 'admin' ? 'Bảng Điều Khiển Phân Lịch Giảng Dạy' : 'Cổng Thông Tin Lịch Giảng Dạy Cá Nhân' }}
                    </h1>
                </div>

                <span class="hidden md:inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-bold rounded-full {{ $user->role === 'admin' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700' }}">
                    <i class="fa-solid {{ $user->role === 'admin' ? 'fa-shield-halved' : 'fa-chalkboard-user' }} text-[10px]"></i>
                    {{ $user->role === 'admin' ? 'Quản Trị Viên' : 'Giảng Viên HUIT' }}
                </span>
            </div>

            <!-- TÌM KIẾM NHANH TRÊN HEADER & THÔNG TIN HỌC KỲ -->
            <div class="flex items-center gap-3">
                <div class="relative hidden sm:block">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" id="tableQuickSearch" onkeyup="filterTableInstant()" placeholder="Tìm nhanh học phần, GV, phòng..."
                        class="w-56 lg:w-72 pl-9 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition font-medium">
                </div>

                <div class="hidden lg:flex items-center gap-2 px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600">
                    <i class="fa-regular fa-calendar-check text-blue-600"></i>
                    <span>Học kỳ I (2026 - 2027)</span>
                </div>

                <button onclick="window.print()" class="no-print hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold shadow-xs transition">
                    <i class="fa-solid fa-print text-slate-500"></i>
                    <span>In</span>
                </button>
            </div>
        </header>

        <!-- NỘI DUNG CUỘN ĐỘC LẬP -->
        <main id="mainContent" class="flex-1 overflow-y-auto p-4 sm:p-6 scroll-smooth">
            <div class="space-y-6 max-w-7xl w-full mx-auto pb-12">

                <!-- THÔNG BÁO FLASH MESSAGE -->
                @if(session('success'))
                    <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl shadow-sm animate-fade-in">
                        <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <div class="font-bold text-sm">Thành công!</div>
                            <div class="text-xs text-emerald-700">{{ session('success') }}</div>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl shadow-sm animate-fade-in">
                        <div class="w-8 h-8 rounded-xl bg-red-500 text-white flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div>
                            <div class="font-bold text-sm">Phát hiện xung đột lịch!</div>
                            <div class="text-xs text-red-700">{{ $errors->first() }}</div>
                        </div>
                    </div>
                @endif

                <!-- BANNER CÁ NHÂN HÓA DÀNH CHO GIẢNG VIÊN -->
                @if($user->role === 'teacher')
                <div class="bg-gradient-to-r from-blue-800 via-indigo-800 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div>
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 text-xs font-semibold text-blue-200 mb-3 backdrop-blur-sm">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                Cổng Tra Cứu Lịch Giảng Dạy Cá Nhân
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                                Kính chào Thầy/Cô, {{ $user->name }}!
                            </h2>
                            <p class="text-blue-100/80 text-sm mt-1 max-w-2xl leading-relaxed">
                                Dưới đây là thời khóa biểu chi tiết của Thầy/Cô. Bạn có thể xem dưới dạng <strong>Lưới Tuần (Thứ x Ca)</strong> hoặc <strong>Danh sách chi tiết</strong> để nắm rõ cơ sở và phòng học cần đến dạy.
                            </p>
                        </div>
                        <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/15 flex-shrink-0">
                            <div class="text-center px-3">
                                <div class="text-3xl font-black text-amber-300">{{ $schedules->count() }}</div>
                                <div class="text-[11px] text-blue-200 uppercase font-semibold mt-0.5">Ca dạy trong tuần</div>
                            </div>
                            <div class="w-px h-10 bg-white/20"></div>
                            <div class="text-center px-3">
                                <div class="text-3xl font-black text-emerald-300">{{ $schedules->pluck('branch_id')->unique()->count() }}</div>
                                <div class="text-[11px] text-blue-200 uppercase font-semibold mt-0.5">Cơ sở cần đến</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- 4 THẺ KPI THỐNG KÊ NHANH -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tổng số ca dạy</p>
                            <p class="text-2xl font-black text-slate-800 mt-1">{{ $schedules->count() }}</p>
                            <p class="text-[11px] text-blue-600 font-semibold mt-1 flex items-center gap-1">
                                <i class="fa-regular fa-clock"></i> Cả tuần học kỳ I
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-xs">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Cơ sở đào tạo</p>
                            <p class="text-2xl font-black text-slate-800 mt-1">{{ $branches->count() }}</p>
                            <p class="text-[11px] text-emerald-600 font-semibold mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot"></i> Tân Phú & TT Thực hành
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shadow-xs">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Đội ngũ Giảng viên</p>
                            <p class="text-2xl font-black text-slate-800 mt-1">{{ $teachers->count() }}</p>
                            <p class="text-[11px] text-amber-600 font-semibold mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-graduation-cap"></i> 4 Chuyên môn chính
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shadow-xs">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Trạng thái hệ thống</p>
                            <p class="text-sm font-extrabold text-emerald-600 mt-2 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Tối ưu phân lịch
                            </p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Không khoảng trống chết</p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl shadow-xs">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </div>
                    </div>
                </div>

                @if($user->role === 'admin')
                <!-- HÀNG 2: FORM THÊM / PHÂN LỊCH THÔNG MINH (2/3) + BIỂU ĐỒ PHÂN BỔ (1/3) -->
                <div id="form-phan-lich" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- FORM PHÂN LỊCH THÔNG MINH -->
                    <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/70 flex flex-wrap items-center justify-between gap-2">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center text-sm shadow-xs">
                                        <i class="fa-solid fa-calendar-plus"></i>
                                    </div>
                                    <div>
                                        <h2 class="font-bold text-slate-900 text-sm sm:text-base leading-tight">
                                            Thêm Lịch Giảng Dạy Mới (Gợi Ý GV Trống Lịch)
                                        </h2>
                                        <p class="text-[11px] text-slate-500">Tự động phát hiện trùng lịch, phòng học và kiểm tra di chuyển</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold border border-blue-200/80">
                                    <i class="fa-solid fa-brain mr-1"></i> AI Gợi ý
                                </span>
                            </div>

                            <form action="{{ route('schedules.store') }}" method="POST" class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                                @csrf
                                
                                <div>
                                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1.5 tracking-wider">
                                        <i class="fa-solid fa-building-columns text-slate-400 mr-1"></i> Cơ sở giảng dạy
                                    </label>
                                    <select name="branch_id" id="branch_id" onchange="fetchSuggestions()" class="w-full rounded-xl border-slate-300 bg-slate-50/50 py-2.5 px-3 text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition font-medium">
                                        @foreach($branches as $b)
                                            <option value="{{ $b->id }}">{{ $b->branch_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1.5 tracking-wider">
                                            <i class="fa-solid fa-calendar-day text-slate-400 mr-1"></i> Thứ
                                        </label>
                                        <select name="day_of_week" id="day_of_week" onchange="fetchSuggestions()" class="w-full rounded-xl border-slate-300 bg-slate-50/50 py-2.5 px-3 text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition font-medium">
                                            @for($d = 2; $d <= 7; $d++)
                                                <option value="{{ $d }}">Thứ {{ $d }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1.5 tracking-wider">
                                            <i class="fa-solid fa-clock text-slate-400 mr-1"></i> Ca học
                                        </label>
                                        <select name="shift_or_periods" id="shift_or_periods" onchange="fetchSuggestions()" class="w-full rounded-xl border-slate-300 bg-slate-50/50 py-2.5 px-3 text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition font-medium">
                                            <option value="Sáng (Tiết 1-3)">Sáng (Tiết 1-3)</option>
                                            <option value="Sáng (Tiết 4-6)">Sáng (Tiết 4-6)</option>
                                            <option value="Chiều (Tiết 7-9)">Chiều (Tiết 7-9)</option>
                                            <option value="Chiều (Tiết 10-12)">Chiều (Tiết 10-12)</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1.5 tracking-wider">
                                        <i class="fa-solid fa-filter text-slate-400 mr-1"></i> Lọc Chuyên môn (Tùy chọn)
                                    </label>
                                    <input type="text" id="expertise" onkeyup="fetchSuggestions()" placeholder="VD: Mã nguồn mở, CSDL, Trí tuệ nhân tạo..."
                                        class="w-full rounded-xl border-slate-300 bg-slate-50/50 py-2.5 px-3 text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition font-medium">
                                </div>

                                <div class="grid grid-cols-3 gap-3">
                                    <div class="col-span-2">
                                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1.5 tracking-wider">
                                            <i class="fa-solid fa-book-open text-slate-400 mr-1"></i> Tên Học phần
                                        </label>
                                        <input type="text" name="subject_name" required placeholder="VD: Lập trình Mã nguồn mở"
                                            class="w-full rounded-xl border-slate-300 bg-slate-50/50 py-2.5 px-3 text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition font-medium">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1.5 tracking-wider">
                                            <i class="fa-solid fa-door-open text-slate-400 mr-1"></i> Phòng
                                        </label>
                                        <input type="text" name="room" required placeholder="PM.03"
                                            class="w-full rounded-xl border-slate-300 bg-slate-50/50 py-2.5 px-3 text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition font-medium">
                                    </div>
                                </div>

                                <!-- THẺ GỢI Ý GIẢNG VIÊN THÔNG MINH -->
                                <div class="md:col-span-2 bg-gradient-to-br from-emerald-50/80 to-teal-50/40 p-4 rounded-2xl border border-emerald-200/90 shadow-2xs">
                                    <div class="flex items-center justify-between mb-2">
                                        <label class="block text-xs font-bold text-emerald-800 uppercase tracking-wider flex items-center gap-1.5">
                                            <i class="fa-solid fa-user-check text-emerald-600"></i> Giảng viên phù hợp (Đã tự động loại trừ người trùng lịch):
                                        </label>
                                        <span id="suggestionCount" class="text-[11px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full"></span>
                                    </div>

                                    <select name="teacher_id" id="teacher_select" required class="w-full rounded-xl border-emerald-300 bg-white py-2.5 px-3 text-sm text-slate-800 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none transition font-semibold">
                                        @foreach($teachers as $t)
                                            <option value="{{ $t->id }}">{{ $t->full_name }} — Chuyên môn: {{ $t->expertise }}</option>
                                        @endforeach
                                    </select>

                                    <!-- THẺ GHI CHÚ LỘ TRÌNH DI CHUYỂN -->
                                    <div id="travel_note_box" class="mt-2.5 flex items-center gap-2 text-xs font-semibold px-3 py-2 rounded-xl bg-white/80 border border-emerald-200 text-emerald-800">
                                        <i class="fa-solid fa-route text-emerald-600"></i>
                                        <span id="travel_note">Đang phân tích tối ưu thời gian di chuyển...</span>
                                    </div>
                                </div>

                                <div class="md:col-span-2 flex justify-end pt-2">
                                    <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-sm px-6 py-3 rounded-xl shadow-md shadow-blue-500/25 hover:shadow-blue-500/40 transition">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                        <span>Lưu & Phân Lịch Giảng Dạy</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- BIỂU ĐỒ PHÂN BỔ CƠ SỞ (CHART.JS) -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/70">
                            <h2 class="font-bold text-slate-900 text-sm sm:text-base flex items-center gap-2">
                                <i class="fa-solid fa-chart-pie text-blue-600"></i>
                                Phân Bổ Ca Dạy Theo Cơ Sở
                            </h2>
                            <p class="text-[11px] text-slate-500">Tỷ trọng số ca phân bổ tại các địa điểm</p>
                        </div>

                        <div class="p-6 flex-1 flex flex-col items-center justify-center">
                            <div class="relative w-full" style="height: 220px;">
                                <canvas id="branchChart"></canvas>
                            </div>

                            <!-- DANH SÁCH CHI TIẾT TỪNG CƠ SỞ DƯỚI BIỂU ĐỒ -->
                            <div class="w-full mt-4 space-y-2 border-t border-slate-100 pt-3">
                                @foreach($branchStats as $idx => $stat)
                                <div class="flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full {{ $idx === 0 ? 'bg-blue-600' : ($idx === 1 ? 'bg-emerald-500' : 'bg-amber-500') }}"></span>
                                        <span class="font-semibold text-slate-700 truncate max-w-[170px]">{{ $stat->branch_name }}</span>
                                    </div>
                                    <span class="font-bold text-slate-900 bg-slate-100 px-2 py-0.5 rounded-md">{{ $stat->schedules_count }} ca</span>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="px-6 py-2.5 bg-slate-50 border-t border-slate-100 text-[11px] text-slate-400 text-center font-medium">
                            Dữ liệu đồng bộ trực tiếp từ CSDL MySQL
                        </div>
                    </div>
                </div>
                @endif

                <!-- HÀNG 3: BẢNG & LƯỚI THỜI KHÓA BIỂU -->
                <div id="bang-tkb" class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                    
                    <!-- THANH CÔNG CỤ BẢNG: TAB CHUYỂN ĐỔI CHẾ ĐỘ XEM & LỌC -->
                    <div id="bo-loc-lich" class="px-6 py-4 border-b border-slate-200 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 bg-slate-50/70">
                        <div class="flex flex-wrap items-center gap-3">
                            <h2 class="font-bold text-slate-900 text-base flex items-center gap-2">
                                <i class="fa-solid fa-calendar-days text-blue-600"></i>
                                <span>Thời Khóa Biểu Chi Tiết</span>
                                <span id="tableRowsBadge" class="ml-1 px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold font-mono">
                                    {{ $schedules->count() }} ca
                                </span>
                            </h2>

                            <!-- NÚT CHUYỂN ĐỔI 2 CHẾ ĐỘ XEM (VIEW TOGGLE) -->
                            <div id="viewToggleContainer" class="inline-flex p-1 bg-slate-200/80 rounded-xl text-xs font-bold">
                                <button type="button" id="btnViewGrid" onclick="switchView('grid')" class="px-3 py-1.5 rounded-lg bg-white text-blue-700 shadow-xs transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-table-cells"></i> Lưới Tuần (Thứ x Ca)
                                </button>
                                <button type="button" id="btnViewTable" onclick="switchView('table')" class="px-3 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-list-ul"></i> Danh Sách Bảng
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2.5">
                            @if($user->role === 'admin')
                            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap items-center gap-2">
                                <select name="branch_id" class="rounded-xl border-slate-300 text-xs py-2 px-2.5 bg-white font-medium focus:ring-2 focus:ring-blue-100 outline-none">
                                    <option value="">-- Tất cả Cơ sở --</option>
                                    @foreach($branches as $b)
                                        <option value="{{ $b->id }}" {{ request('branch_id') == $b->id ? 'selected' : '' }}>{{ $b->branch_name }}</option>
                                    @endforeach
                                </select>

                                <select name="teacher_id" class="rounded-xl border-slate-300 text-xs py-2 px-2.5 bg-white font-medium focus:ring-2 focus:ring-blue-100 outline-none">
                                    <option value="">-- Chọn Giảng viên cụ thể --</option>
                                    @foreach($teachers as $t)
                                        <option value="{{ $t->id }}" {{ request('teacher_id') == $t->id ? 'selected' : '' }}>{{ $t->full_name }}</option>
                                    @endforeach
                                </select>

                                <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition shadow-xs flex items-center gap-1.5">
                                    <i class="fa-solid fa-filter"></i> Lọc TKB
                                </button>

                                @if(request('branch_id') || request('teacher_id'))
                                <a href="{{ route('dashboard') }}" class="bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 text-xs font-bold px-3 py-2 rounded-xl transition">
                                    Đặt lại
                                </a>
                                @endif
                            </form>
                            @endif

                            <button onclick="window.print()" class="bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold px-3 py-2 rounded-xl transition flex items-center gap-1.5">
                                <i class="fa-solid fa-print"></i> In TKB
                            </button>
                        </div>
                    </div>

                    <!-- CHẾ ĐỘ XEM 1: LƯỚI MA TRẬN THỜI KHÓA BIỂU TUẦN (WEEKLY GRID) -->
                    <div id="weeklyGridView" class="p-4 sm:p-6 overflow-x-auto">
                        <div class="min-w-[900px]">
                            <!-- BẢNG MA TRẬN 6 NGÀY (THỨ 2 ĐẾN THỨ 7) X 4 CA HỌC -->
                            @php
                                $shiftsList = ['Sáng (Tiết 1-3)', 'Sáng (Tiết 4-6)', 'Chiều (Tiết 7-9)', 'Chiều (Tiết 10-12)'];
                                $daysList = [2, 3, 4, 5, 6, 7];
                            @endphp

                            <div class="grid grid-cols-7 gap-2.5 text-center text-xs font-extrabold uppercase mb-2">
                                <div class="bg-slate-100 py-3 rounded-xl text-slate-600 border border-slate-200/80">Ca / Buổi</div>
                                @foreach($daysList as $d)
                                <div class="bg-blue-50 py-3 rounded-xl text-blue-800 border border-blue-200">
                                    Thứ {{ $d }}
                                </div>
                                @endforeach
                            </div>

                            @foreach($shiftsList as $shift)
                            <div class="grid grid-cols-7 gap-2.5 mb-2.5 items-stretch">
                                <!-- CỘT CA HỌC -->
                                <div class="bg-slate-100/90 rounded-2xl p-3 flex flex-col justify-center items-center text-center border border-slate-200/70">
                                    <span class="font-bold text-slate-800 text-xs flex items-center gap-1">
                                        @if(str_contains($shift, 'Sáng'))
                                            <i class="fa-regular fa-sun text-amber-500"></i>
                                        @else
                                            <i class="fa-solid fa-cloud-moon text-indigo-500"></i>
                                        @endif
                                        {{ $shift }}
                                    </span>
                                </div>

                                <!-- CÁC CỘT TỪ THỨ 2 ĐẾN THỨ 7 -->
                                @foreach($daysList as $d)
                                    @php
                                        $cellSchedules = $schedules->filter(fn($s) => $s->day_of_week == $d && $s->shift_or_periods === $shift);
                                    @endphp

                                    <div class="rounded-2xl p-2.5 min-h-[110px] flex flex-col justify-between transition {{ $cellSchedules->count() > 0 ? 'bg-blue-50/70 border border-blue-200 hover:border-blue-400 hover:shadow-xs' : 'bg-slate-50/50 border border-dashed border-slate-200 hover:bg-slate-50' }}">
                                        @forelse($cellSchedules as $sch)
                                            <div class="bg-white p-2.5 rounded-xl border border-blue-200/90 shadow-2xs mb-1.5 last:mb-0 text-left">
                                                <div class="font-bold text-blue-900 text-xs leading-tight mb-1 flex items-center justify-between">
                                                    <span class="truncate">{{ $sch->subject_name }}</span>
                                                    @if($user->role === 'admin')
                                                    <button type="button" onclick="openEditModal({{ json_encode($sch) }})" title="Sửa ca dạy" class="text-blue-500 hover:text-blue-700 ml-1 no-print">
                                                        <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                                    </button>
                                                    @endif
                                                </div>

                                                <div class="text-[11px] text-slate-700 font-semibold flex items-center gap-1 truncate mb-0.5">
                                                    <i class="fa-solid fa-chalkboard-user text-[10px] text-slate-400"></i>
                                                    <span>{{ $sch->teacher->full_name }}</span>
                                                </div>

                                                <div class="text-[10px] text-slate-500 truncate mb-1">
                                                    <i class="fa-solid fa-map-pin text-[9px] text-rose-500"></i>
                                                    <span>{{ $sch->branch->branch_name }}</span>
                                                </div>

                                                <div class="inline-block px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 font-mono text-[10px] font-bold">
                                                    Phòng: {{ $sch->room }}
                                                </div>
                                            </div>
                                        @empty
                                            <div class="h-full flex items-center justify-center text-[11px] text-slate-300 font-medium select-none">
                                                <i class="fa-solid fa-plus text-[9px] mr-1"></i> Trống
                                            </div>
                                        @endforelse
                                    </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- CHẾ ĐỘ XEM 2: DANH SÁCH BẢNG CHI TIẾT (TABLE VIEW) -->
                    <div id="tableView" class="overflow-x-auto hidden">
                        <table id="scheduleDataTable" class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="bg-slate-100/80 text-slate-600 uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-200">
                                    <th class="py-3.5 px-5">Thứ</th>
                                    <th class="py-3.5 px-5">Ca / Tiết Học</th>
                                    <th class="py-3.5 px-5">Tên Học Phần</th>
                                    <th class="py-3.5 px-5">Giảng Viên</th>
                                    <th class="py-3.5 px-5">Cơ Sở Giảng Dạy</th>
                                    <th class="py-3.5 px-5">Phòng Học</th>
                                    @if($user->role === 'admin')
                                    <th class="py-3.5 px-5 text-right no-print">Thao Tác</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100" id="scheduleTableBody">
                                @forelse($schedules as $item)
                                <tr class="schedule-row hover:bg-blue-50/50 transition">
                                    <!-- THỨ -->
                                    <td class="py-4 px-5 whitespace-nowrap">
                                        @php
                                            $dayColors = [
                                                2 => 'bg-blue-100 text-blue-800 border-blue-200',
                                                3 => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                                4 => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                                5 => 'bg-amber-100 text-amber-800 border-amber-200',
                                                6 => 'bg-purple-100 text-purple-800 border-purple-200',
                                                7 => 'bg-rose-100 text-rose-800 border-rose-200',
                                            ];
                                            $colorClass = $dayColors[$item->day_of_week] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold border {{ $colorClass }}">
                                            <i class="fa-regular fa-calendar text-[10px]"></i>
                                            Thứ {{ $item->day_of_week }}
                                        </span>
                                    </td>

                                    <!-- CA DẠY -->
                                    <td class="py-4 px-5 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700">
                                            @if(str_contains($item->shift_or_periods, 'Sáng'))
                                                <i class="fa-regular fa-sun text-amber-500"></i>
                                            @else
                                                <i class="fa-solid fa-cloud-moon text-indigo-500"></i>
                                            @endif
                                            {{ $item->shift_or_periods }}
                                        </span>
                                    </td>

                                    <!-- HỌC PHẦN -->
                                    <td class="py-4 px-5 font-bold text-slate-900 subject-cell">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-xs flex-shrink-0">
                                                <i class="fa-solid fa-book"></i>
                                            </div>
                                            <span>{{ $item->subject_name }}</span>
                                        </div>
                                    </td>

                                    <!-- GIẢNG VIÊN -->
                                    <td class="py-4 px-5 teacher-cell">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs flex-shrink-0 uppercase">
                                                {{ substr($item->teacher->full_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-800 text-sm leading-tight">{{ $item->teacher->full_name }}</div>
                                                <div class="text-[11px] text-slate-400 font-medium">{{ $item->teacher->expertise }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- CƠ SỞ -->
                                    <td class="py-4 px-5 branch-cell">
                                        <div class="font-bold text-slate-800 text-sm flex items-center gap-1.5">
                                            <i class="fa-solid fa-map-pin text-rose-500 text-xs"></i>
                                            {{ $item->branch->branch_name }}
                                        </div>
                                        <div class="text-[11px] text-slate-400 font-medium pl-4">{{ $item->branch->address }}</div>
                                    </td>

                                    <!-- PHÒNG HỌC -->
                                    <td class="py-4 px-5 whitespace-nowrap room-cell">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-800 border border-amber-300 font-mono text-xs font-bold">
                                            <i class="fa-solid fa-door-open text-[10px]"></i>
                                            {{ $item->room }}
                                        </span>
                                    </td>

                                    <!-- THAO TÁC: SỬA & XÓA (ADMIN) -->
                                    @if($user->role === 'admin')
                                    <td class="py-4 px-5 text-right whitespace-nowrap no-print">
                                        <button type="button" onclick="openEditModal({{ json_encode($item) }})" class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-xl text-xs font-bold transition mr-1.5">
                                            <i class="fa-solid fa-pen-to-square mr-1"></i> Sửa
                                        </button>
                                        <form action="{{ route('schedules.destroy', $item) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa ca học [{{ $item->subject_name }}] này?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" title="Xóa ca dạy" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-xl text-xs font-bold transition">
                                                <i class="fa-solid fa-trash-can mr-1"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-slate-400">
                                        <div class="w-16 h-16 rounded-3xl bg-slate-100 flex items-center justify-center mx-auto mb-3 text-2xl text-slate-400">
                                            <i class="fa-regular fa-folder-open"></i>
                                        </div>
                                        <div class="font-bold text-slate-600">Chưa có dữ liệu lịch dạy phù hợp</div>
                                        <div class="text-xs text-slate-400 mt-1">Vui lòng chọn cơ sở hoặc thêm ca dạy mới</div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- FOOTER BẢNG -->
                    <div class="px-6 py-3 bg-slate-50 border-t border-slate-200/80 text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2">
                        <div>
                            Hiển thị <span class="font-bold text-slate-800">{{ $schedules->count() }}</span> ca giảng dạy trong hệ thống
                        </div>
                        <div class="text-[11px] text-slate-400">
                            HUIT Schedule Hub · Phiên bản 2026.1
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<!-- MODAL CHỈNH SỬA LỊCH GIẢNG DẠY (EDIT SCHEDULE MODAL) -->
@if($user->role === 'admin')
<div id="editModal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-xl w-full shadow-2xl border border-slate-100 overflow-hidden animate-scale-up">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-lg"></i>
                <h3 class="font-bold text-base">Cập Nhật / Sửa Lịch Giảng Dạy</h3>
            </div>
            <button type="button" onclick="closeEditModal()" class="w-8 h-8 rounded-lg bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="editScheduleForm" method="POST" action="" class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Cơ sở giảng dạy</label>
                <select name="branch_id" id="edit_branch_id" required class="w-full rounded-xl border-slate-300 py-2.5 px-3 text-sm focus:border-blue-500 outline-none">
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}">{{ $b->branch_name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Giảng viên đảm nhiệm</label>
                <select name="teacher_id" id="edit_teacher_id" required class="w-full rounded-xl border-slate-300 py-2.5 px-3 text-sm focus:border-blue-500 outline-none">
                    @foreach($teachers as $t)
                        <option value="{{ $t->id }}">{{ $t->full_name }} ({{ $t->expertise }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Thứ</label>
                <select name="day_of_week" id="edit_day_of_week" required class="w-full rounded-xl border-slate-300 py-2.5 px-3 text-sm focus:border-blue-500 outline-none">
                    @for($d = 2; $d <= 7; $d++)
                        <option value="{{ $d }}">Thứ {{ $d }}</option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Ca học</label>
                <select name="shift_or_periods" id="edit_shift_or_periods" required class="w-full rounded-xl border-slate-300 py-2.5 px-3 text-sm focus:border-blue-500 outline-none">
                    <option value="Sáng (Tiết 1-3)">Sáng (Tiết 1-3)</option>
                    <option value="Sáng (Tiết 4-6)">Sáng (Tiết 4-6)</option>
                    <option value="Chiều (Tiết 7-9)">Chiều (Tiết 7-9)</option>
                    <option value="Chiều (Tiết 10-12)">Chiều (Tiết 10-12)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Tên Học phần</label>
                <input type="text" name="subject_name" id="edit_subject_name" required class="w-full rounded-xl border-slate-300 py-2.5 px-3 text-sm focus:border-blue-500 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Phòng học</label>
                <input type="text" name="room" id="edit_room" required class="w-full rounded-xl border-slate-300 py-2.5 px-3 text-sm focus:border-blue-500 outline-none">
            </div>

            <div class="sm:col-span-2 flex justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2.5 rounded-xl border border-slate-300 hover:bg-slate-100 text-slate-700 text-xs font-bold transition">
                    Hủy bỏ
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                    <i class="fa-solid fa-check"></i> Lưu Cập Nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- JAVASCRIPT XỬ LÝ GIAO DIỆN & TÍNH NĂNG THÔNG MINH -->
<script>
    // 1. Chuyển đổi giữa 2 chế độ xem: Lưới Tuần (Weekly Grid) & Danh sách bảng (Table View)
    function switchView(viewMode) {
        const gridView = document.getElementById('weeklyGridView');
        const tableView = document.getElementById('tableView');
        const btnGrid = document.getElementById('btnViewGrid');
        const btnTable = document.getElementById('btnViewTable');

        if (viewMode === 'grid') {
            gridView.classList.remove('hidden');
            tableView.classList.add('hidden');
            btnGrid.className = 'px-3 py-1.5 rounded-lg bg-white text-blue-700 shadow-xs transition flex items-center gap-1.5';
            btnTable.className = 'px-3 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition flex items-center gap-1.5';
        } else {
            gridView.classList.add('hidden');
            tableView.classList.remove('hidden');
            btnTable.className = 'px-3 py-1.5 rounded-lg bg-white text-blue-700 shadow-xs transition flex items-center gap-1.5';
            btnGrid.className = 'px-3 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition flex items-center gap-1.5';
        }
    }

    // 2. Mở / Đóng Modal Chỉnh sửa Lịch Dạy (Edit Modal)
    function openEditModal(schedule) {
        const modal = document.getElementById('editModal');
        if (!modal) return;

        const form = document.getElementById('editScheduleForm');
        form.action = `/schedules/${schedule.id}`;

        document.getElementById('edit_branch_id').value = schedule.branch_id;
        document.getElementById('edit_teacher_id').value = schedule.teacher_id;
        document.getElementById('edit_day_of_week').value = schedule.day_of_week;
        document.getElementById('edit_shift_or_periods').value = schedule.shift_or_periods;
        document.getElementById('edit_subject_name').value = schedule.subject_name;
        document.getElementById('edit_room').value = schedule.room;

        modal.classList.remove('hidden');
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        if (modal) modal.classList.add('hidden');
    }

    // 3. Đóng / mở Sidebar mượt mà
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const isDesktop = window.innerWidth >= 768;

        if (isDesktop) {
            sidebar.classList.toggle('md:w-0');
            sidebar.classList.toggle('w-64');
        } else {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    }

    // 4. Cuộn mượt đến từng phần
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

    // 5. Tìm kiếm tức thì trong bảng thời khóa biểu (Live Search)
    function filterTableInstant() {
        const keyword = document.getElementById('tableQuickSearch').value.toLowerCase().trim();
        const rows = document.querySelectorAll('#scheduleTableBody tr.schedule-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            if (text.includes(keyword)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const badge = document.getElementById('tableRowsBadge');
        if (badge) {
            badge.textContent = `${visibleCount} ca`;
        }
    }

    // 6. API Gợi ý Giảng viên rảnh & Đánh giá lộ trình di chuyển
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
                const countBadge = document.getElementById('suggestionCount');
                select.innerHTML = '';

                if (!data || data.length === 0) {
                    select.innerHTML = '<option value="">⚠️ Không có giảng viên rảnh phù hợp trong khung giờ này!</option>';
                    note.textContent = 'Khung giờ này tất cả giảng viên chuyên môn đều đã có lịch dạy!';
                    note.parentElement.className = 'mt-2.5 flex items-center gap-2 text-xs font-semibold px-3 py-2 rounded-xl bg-red-50 border border-red-200 text-red-700';
                    if (countBadge) countBadge.textContent = '0 GV rảnh';
                    return;
                }

                if (countBadge) countBadge.textContent = `${data.length} GV rảnh`;

                data.forEach((t, idx) => {
                    const opt = document.createElement('option');
                    opt.value = t.id;
                    opt.textContent = `${t.full_name} — [${t.expertise}] (${t.travel_warning})`;
                    select.appendChild(opt);

                    if (idx === 0) {
                        note.textContent = t.travel_warning;
                        if (t.travel_warning.includes('Cảnh báo')) {
                            note.parentElement.className = 'mt-2.5 flex items-center gap-2 text-xs font-semibold px-3 py-2 rounded-xl bg-amber-50 border border-amber-200 text-amber-800';
                        } else if (t.travel_warning.includes('Lưu ý')) {
                            note.parentElement.className = 'mt-2.5 flex items-center gap-2 text-xs font-semibold px-3 py-2 rounded-xl bg-yellow-50 border border-yellow-200 text-yellow-800';
                        } else {
                            note.parentElement.className = 'mt-2.5 flex items-center gap-2 text-xs font-semibold px-3 py-2 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800';
                        }
                    }
                });
            })
            .catch(err => {
                console.error("Lỗi gọi API gợi ý:", err);
            });
    }
</script>

@if($user->role === 'admin')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        fetchSuggestions();

        const labels = JSON.parse('{!! json_encode($branchStats->pluck("branch_name")) !!}');
        const counts = JSON.parse('{!! json_encode($branchStats->pluck("schedules_count")) !!}');

        const ctx = document.getElementById('branchChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: counts,
                        backgroundColor: ['#2563eb', '#10b981', '#f59e0b'],
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const value = context.parsed;
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return ` ${context.label}: ${value} ca (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endif

</body>
</html>
