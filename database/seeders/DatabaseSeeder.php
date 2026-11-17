<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Schedule;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('vi_VN');

        Branch::create(['branch_name' => 'Cơ sở chính Tân Phú', 'address' => '140 Lê Trọng Tấn, Tân Phú, TP.HCM']);
        Branch::create(['branch_name' => 'Trung tâm Thí nghiệm Thực hành', 'address' => '93 Tân Kỳ Tân Quý, Tân Phú, TP.HCM']);
        Branch::create(['branch_name' => 'Cơ sở Chế Lan Viên', 'address' => '70 Chế Lan Viên, Tân Phú, TP.HCM']);

        $expertises = ['Lập trình Mã nguồn mở', 'Cơ sở dữ liệu', 'Trí tuệ nhân tạo', 'Mạng máy tính'];
        $shifts = ['Sáng (Tiết 1-3)', 'Sáng (Tiết 4-6)', 'Chiều (Tiết 7-9)', 'Chiều (Tiết 10-12)'];

        for ($i = 1; $i <= 8; $i++) {
            $teacher = Teacher::create([
                'full_name' => $faker->name(),
                'email' => "gv{$i}@huit.edu.vn",
                'phone' => $faker->phoneNumber(),
                'expertise' => $expertises[array_rand($expertises)],
            ]);

            User::create([
                'name' => $teacher->full_name,
                'email' => $teacher->email,
                'password' => Hash::make('12345678'),
                'role' => 'teacher',
                'teacher_id' => $teacher->id,
            ]);
        }

        User::create([
            'name' => 'Phòng Đào Tạo HUIT',
            'email' => 'admin@huit.edu.vn',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        for ($j = 0; $j < 15; $j++) {
            Schedule::create([
                'teacher_id' => rand(1, 8),
                'branch_id' => rand(1, 3),
                'subject_name' => 'Học phần ' . $faker->words(2, true),
                'room' => 'P.' . rand(101, 505),
                'day_of_week' => rand(2, 7),
                'shift_or_periods' => $shifts[array_rand($shifts)],
            ]);
        }
    }
}