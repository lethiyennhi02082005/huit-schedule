<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Schedule;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Schedule::with(['teacher', 'branch']);

        // Giảng viên chỉ xem lịch cá nhân; Admin xem tất cả và lọc được
        if ($user->role === 'teacher') {
            $query->where('teacher_id', $user->teacher_id);
        } else {
            if ($request->filled('branch_id')) {
                $query->where('branch_id', $request->branch_id);
            }
            if ($request->filled('teacher_id')) {
                $query->where('teacher_id', $request->teacher_id);
            }
        }

        $schedules = $query->orderBy('day_of_week')->orderBy('shift_or_periods')->get();
        $branches = Branch::all();
        $teachers = Teacher::all();
        $branchStats = Branch::withCount('schedules')->get();

        return view('schedules.index', compact('schedules', 'branches', 'teachers', 'branchStats', 'user'));
    }

    // API gợi ý giảng viên rảnh, đúng chuyên môn, tối ưu di chuyển & tránh khoảng trống chết
    public function suggestTeachers(Request $request)
    {
        $day = $request->day_of_week;
        $shift = $request->shift_or_periods;
        $expertise = $request->expertise;
        $branchId = $request->branch_id;

        $busyTeacherIds = Schedule::where('day_of_week', $day)
            ->where('shift_or_periods', $shift)
            ->pluck('teacher_id');

        $availableTeachers = Teacher::whereNotIn('id', $busyTeacherIds)
            ->when($expertise, function ($q) use ($expertise) {
                $q->where('expertise', 'LIKE', "%{$expertise}%");
            })
            ->get()
            ->map(function ($teacher) use ($day, $branchId, $shift) {
                $sameDaySchedules = Schedule::where('teacher_id', $teacher->id)
                    ->where('day_of_week', $day)
                    ->get();

                $otherBranchSameDay = $sameDaySchedules->where('branch_id', '!=', $branchId)->isNotEmpty();

                // Kiểm tra khoảng trống chết (VD: dạy Tiết 1-3 và Tiết 10-12 trong cùng ngày)
                $hasDeadGap = false;
                if (($shift === 'Sáng (Tiết 1-3)' && $sameDaySchedules->contains('shift_or_periods', 'Chiều (Tiết 10-12)')) ||
                    ($shift === 'Chiều (Tiết 10-12)' && $sameDaySchedules->contains('shift_or_periods', 'Sáng (Tiết 1-3)'))) {
                    $hasDeadGap = true;
                }

                if ($otherBranchSameDay) {
                    $teacher->travel_warning = 'Cảnh báo: GV có lịch tại cơ sở khác trong ngày này (lưu ý di chuyển)';
                } elseif ($hasDeadGap) {
                    $teacher->travel_warning = 'Lưu ý: Có khoảng trống chết giữa ca đầu sáng và cuối chiều';
                } else {
                    $teacher->travel_warning = 'Tối ưu: Lịch liền mạch, không di chuyển trái cơ sở';
                }

                return $teacher;
            });

        return response()->json($availableTeachers);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Chỉ Quản trị viên mới có quyền thực hiện thao tác này.');
        }

        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'branch_id' => 'required|exists:branches,id',
            'subject_name' => 'required|string',
            'room' => 'required|string',
            'day_of_week' => 'required|integer|between:2,7',
            'shift_or_periods' => 'required|string',
        ]);

        if ($this->hasConflict($request)) {
            return back()->withErrors(['msg' => 'Lỗi: Trùng lịch giảng viên hoặc trùng phòng học trong khung giờ này!']);
        }

        Schedule::create($request->all());
        return back()->with('success', 'Phân lịch giảng dạy thành công!');
    }

    // Cập nhật / Sửa lịch dạy (Hoàn thiện đủ CRUD)
    public function update(Request $request, Schedule $schedule)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Chỉ Quản trị viên mới có quyền thực hiện thao tác này.');
        }

        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'branch_id' => 'required|exists:branches,id',
            'subject_name' => 'required|string',
            'room' => 'required|string',
            'day_of_week' => 'required|integer|between:2,7',
            'shift_or_periods' => 'required|string',
        ]);

        if ($this->hasConflict($request, $schedule->id)) {
            return back()->withErrors(['msg' => 'Lỗi cập nhật: Trùng lịch giảng viên hoặc phòng học!']);
        }

        $schedule->update($request->all());
        return back()->with('success', 'Cập nhật lịch giảng dạy thành công!');
    }

    public function destroy(Schedule $schedule)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Chỉ Quản trị viên mới có quyền thực hiện thao tác này.');
        }

        $schedule->delete();
        return back()->with('success', 'Đã xóa lịch dạy.');
    }

    private function hasConflict(Request $request, $ignoreId = null)
    {
        $teacherConflict = Schedule::where('teacher_id', $request->teacher_id)
            ->where('day_of_week', $request->day_of_week)
            ->where('shift_or_periods', $request->shift_or_periods)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists();

        $roomConflict = Schedule::where('branch_id', $request->branch_id)
            ->where('room', $request->room)
            ->where('day_of_week', $request->day_of_week)
            ->where('shift_or_periods', $request->shift_or_periods)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists();

        return $teacherConflict || $roomConflict;
    }
}