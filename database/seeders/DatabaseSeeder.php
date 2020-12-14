<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factory;
require_once 'vendor/autoload.php';
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $teacherName = $this->genTeacherName();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('teachers')->truncate();
        DB::table('courses')->truncate();
        DB::table('course_levels')->truncate();
        DB::table('posts')->truncate();
        DB::table('registration_statuses')->truncate();
        DB::table('subjects')->truncate();
        DB::table('teacher_course_registrations')->truncate();
        DB::table('images')->truncate();
        DB::table('teacher_levels')->truncate();
        DB::table('posts')->truncate();
        DB::table('teacher_account_statuses')->truncate();
        DB::table('subject_teachers')->truncate();
        DB::table('course_level_teachers')->truncate();
        DB::table('teacher_account_statuses')->truncate();
        DB::table('enquiries')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = \Faker\Factory::create();
        DB::table('users')->insert([
            'name' => 'Nguời quản lý',
            'email' => 'admin@giasudanang.com',
            'password' => bcrypt('111111'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        $teacherLevels = array(
                                'Học sinh',
                                'Sinh viên chưa ra trường',
                                'Sinh viên đã ra trường',
                                'Giáo viên',
                                'Giảng viên đại học'
                            );
        foreach($teacherLevels as $lv) {
            DB::table('teacher_levels')->insert([
                'display_name' => $lv,
                ]);
        }
        unset($teacherLevels);

        $teacherAccountStatuses = array(
            'CONFIRMED' => 'đã xác nhận',
            'INELIGIBLE' => 'không đạt điều kiện',
            'REQUEST_VERIFICATION' => 'yêu cầu xác nhận',
        );
        foreach($teacherAccountStatuses as $key => $val) {
            DB::table('teacher_account_statuses')->insert([
                'name' => $key,
                'display_name' => $val,
            ]);
        }

        $teacherLevels = DB::table('teacher_levels')->get();
        DB::table('teachers')->insert([
            'name' => 'Nguyễn Đình Nhân',
            'email' => 'giasu@gmail.com',
            'password' => bcrypt('111111'),
            'phone'   => '+84368054220',
            'address' => 'Tôn Đức Thắng, Quân Liên Chiểu, Tp Đà Nẵng',
            'is_male' => true,
            'identity_card' => $faker->numberBetween($min = 1000, $max = 9000) * $faker->numberBetween($min = 1000, $max = 9000),
            'university' => $this->randomDaiHoc(),
            'speciality' => $this->randomChuyenNganh(),
            'teacher_level_id' => 2,
            'reference_tuition' => $faker->numberBetween($min = 10, $max = 30) . '0000',
            'year_of_birth' => $faker->numberBetween($min = 1970, $max = 2000),
            'teacher_account_status_id' => '1',
            'email_verified_at' => now(),
        ]);



        DB::table('teachers')->insert([
            'name' => $faker->name,
            'email' => 'tkmoi@gmail.com',
            'password' => bcrypt('111111'),
            'phone'   => $faker->e164PhoneNumber,
            'address' => $faker->address,
            'is_male' => $faker->randomElement($array = array ('0','1')),
            'identity_card' => $faker->numberBetween($min = 1000, $max = 9000) * $faker->numberBetween($min = 1000, $max = 9000),
            'university' => $this->randomDaiHoc(),
            'speciality' => $this->randomChuyenNganh(),
            'teacher_level_id' =>$faker->randomElement($teacherLevels->pluck('id')->toArray()),
            'reference_tuition' => $faker->numberBetween($min = 10, $max = 30) . '0000',
            'year_of_birth' => $faker->numberBetween($min = 1970, $max = 2000),
            'teacher_account_status_id' => '2',
            'email_verified_at' => now(),
        ]);
        foreach ($teacherName as $name) {
            DB::table('teachers')->insert([
                'name' => $name,
                'email' => Str::slug($name, ''). '@gmail.com',
                'password' => $faker->password,
                'phone'   => $faker->e164PhoneNumber,
                'address' => $faker->address,
                'is_male' => $faker->randomElement($array = array ('0','1')),
                'identity_card' => $faker->numberBetween($min = 1000, $max = 9000) * $faker->numberBetween($min = 1000, $max = 9000),
                'university' =>$this->randomDaiHoc(),
                'speciality' => $this->randomChuyenNganh(),
                'teacher_level_id' =>$faker->randomElement($teacherLevels->pluck('id')->toArray()),
                'reference_tuition' => $faker->numberBetween($min = 100, $max = 400) . '000',
                'year_of_birth' => $faker->numberBetween($min = 1970, $max = 2000),
                'teacher_account_status_id' => $faker->randomElement($array = array (null,'1', '2', '3','1','1','1','1')),
            ]);
        }



        $subjects = array(
            'Vietnamese' => 'Tiếng Việt',
            'Maths' => 'Toán',
            'philology' => 'Ngữ Văn',
            'English' => 'Tiếng Anh',
            'Physical' => 'Vật Lý',
            'Chemistry' => 'Hoá Học',
            'Biology' => 'Sinh học',
            'History' => 'Lịch sử',
            'Geography' => 'Địa Lý',
            // 'Painting' => 'Hội Hoạ',
            // 'Chinese' => 'Tiếng Trung',
            // 'Japanese' => 'Tiếng Nhật',
            // 'Piano' => 'Đàn Piano',
            // 'Organ' => 'Đàn Organ',
            // 'Guitar' => 'Đàn Guitar',
        );
        foreach($subjects as $key => $val) {
            DB::table('subjects')->insert([
                'name' => $key,
                'display_name' => $val,
            ]);
        }
        $courseLevels = array(
            'grade_1' => 'lớp 1',
            'grade_2' => 'lớp 2',
            'grade_3' => 'lớp 3',
            'grade_4' => 'lớp 4',
            'grade_5' => 'lớp 5',
            'grade_6' => 'lớp 6',
            'grade_7' => 'lớp 7',
            'grade_8' => 'lớp 8',
            'grade_9' => 'lớp 9',
            'grade_10' => 'lớp 10',
            'grade_11' => 'lớp 11',
            'grade_12' => 'lớp 12',
        );
        foreach($courseLevels as $key => $val) {
            DB::table('course_levels')->insert([
                'name' => $key,
                'display_name' => $val,
            ]);
        }

        $courseLvs = DB::table('course_levels')->get();
        \App\Models\Teacher::all()->each(function ($teacher) use ($courseLvs) {
            $teacher->courseLevels()->attach(
                $courseLvs->random(rand(1, 5))->pluck('id')
            );
        });

        $subjects = DB::table('subjects')->get();
        \App\Models\Teacher::all()->each(function ($teacher) use ($subjects) {
            $teacher->subjects()->attach(
                $subjects->random(rand(1, 5))->pluck('id')
            );
        });


        $registrationStatuses = array(
            'pending' => 'đang chờ',
            'eligible' => 'đủ điều kiện',
            'ineligible' => 'không đủ điều kiện',
        );
        foreach($registrationStatuses as $key => $val) {
            DB::table('registration_statuses')->insert([
                'name' => $key,
                'display_name' => $val,
            ]);
        }


        $subjects = DB::table('subjects')->get();
        $courseLevels = DB::table('course_levels')->get();

        $subject_levels = array();
        foreach($subjects as $sub) {
            foreach($courseLevels as $cou) {

                if($sub->id == 1){
                    if($cou->id > 5){
                        continue;
                    }
                }
                if($sub->id > 2) {
                    if($cou->id <= 5) {
                        continue;
                    }
                }
                if($cou->id == 11 || $cou->id == 12){
                    continue;
                }
                $title = 'tuyển gia sư dạy môn ' . $sub->display_name . ' ' . $cou->display_name;
                DB::table('courses')->insert([
                    'subject_id' => $sub->id,
                    'course_level_id' => $cou->id,
                    // 'time_working' => 'T2 - T7',
                    'tuition_per_session' =>  $faker->numberBetween($min = 15, $max = 30) . '0000',
                    'slug' => Str::slug($title, '-'),
                    'title' => $title,
                ]);
            }
        }

        $teachers = DB::table('teachers')->where('teacher_account_status_id', '1')->get();
        $courses= DB::table('courses')->get();
        $registrationStatuses = DB::table('registration_statuses')->get();
        foreach($courses as $course) {
            foreach(range(0,7) as $index){
                DB::table('teacher_course_registrations')->insert([
                    'teacher_id' => $faker->randomElement($teachers->pluck('id')->toArray()),
                    'course_id' => $course->id,
                    'registration_status_id' => $faker->randomElement($registrationStatuses->pluck('id')->toArray()),
                    ]);
                }
            }
        foreach($teachers as $tea) {
            DB::table('images')->insert([
                'teacher_id' => $tea->id,
                'src' => '/uploads/avatar/'. $faker->numberBetween($min = 1, $max = 10) . '.jpg',
                'image_type' => 'TEACHER_AVATAR'
            ]);
            foreach(range(0, 1) as $index){
                DB::table('images')->insert([
                    'teacher_id' => $tea->id,
                    'src' => 'https://picsum.photos/id/1047/300/200',
                    'image_type' => 'TEACHER_IDENTITY_CARD'
                ]);
            }
            foreach(range(0, 2) as $index){
                DB::table('images')->insert([
                    'teacher_id' => $tea->id,
                    'src' => 'https://picsum.photos/id/1033/300/200',
                    'image_type' => 'TEACHER_DEGREE'
                ]);
            }
        }

        foreach (range(0, 30) as $index) {
            DB::table('posts')->insert([
                'title' => $faker->name,
                'slug' => Str::slug($faker->name, '-'),
                'content' => $faker->randomHtml(4,5),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }

        $listPages = array(
            'giới thiệu',
            'phương thức liên hệ',
            'thông báo',
            'hợp đồng gia sư',
            'hướng dẫn nhận lớp',
            'hướng dẫn đăng ký làm gia sư',
            'gia sư cần biết',
            'bảng giá tham khảo',
            'phụ huynh cần biết',
        );
        foreach ($listPages as $value) {
            DB::table('posts')->insert([
                'title' => $value,
                'slug' => Str::slug($value, '-'),
                'content' => '<h1 style="text-align: center; color: yellow;"><center>' . $value . '</center></h1><br><hr><br>' . $faker->text(500),
                'category' => 'PAGE',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }

        foreach ($teacherName as $name) {
            DB::table('enquiries')->insert([
                'flag_is_checked' => $faker->randomElement($array = array (true, false)),
                'name' => $name,
                'email' => Str::slug($name, ''). '@yahoo.com',
                'phone' => $faker->e164PhoneNumber,
                'title' => $faker->randomElement($array = array ('Yêu cầu mở thêm lớp', 'Không tìm thấy gia sư như yêu cầu', 'Cần hướng dẫn đăng ký', 'Yêu cầu xét duyệt', 'Thắc mắc yêu cầu')),
                'content' => $faker->text(200),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
        foreach($teacherName as $name)
        {
            $flag_is_confirmed = $faker->randomElement($array = array (true, false));
            if($flag_is_confirmed) {
                $flag_is_checked = true;
            }else{
                $flag_is_checked = $faker->randomElement($array = array (true, false));
            }
            $cou_se =$faker->randomElement($courses);
            DB::table('parent_registers')->insert([
                'flag_is_confirmed' => $flag_is_confirmed,
                'flag_is_checked' => $flag_is_checked,
                'fullname' => $name,
                'email' => Str::slug($name, ''). '@gmail.com',
                'phone'   => $faker->e164PhoneNumber,
                'address' => $faker->address,
                'teacher_id' => $faker->randomElement($teachers->pluck('id')->toArray()),
                'course_id' => $cou_se->id,
                'time_working' => 'T2 - T7',
                'tuition_per_session' => $cou_se->tuition_per_session,
            ]);
        }

    }
    private function genTeacherName()
    {
        return array(
            "Nguyễn Huỳnh Minh Phụng",
"Nguyễn Võ Thanh An",
"Hoàng Hữu Đạt",
"Đào Ngọc Quý",
"Nguyễn Hoài Nhân",
"Dương Hồng Nhật",
"Phan Thị Hoàng Trinh",
"Trần Thị Như Quỳnh",
"Phạm Đỗ Trình",
"Lê Tâm Hoàng Ngân",
"Bùi Thị Ngọc ÁNh",
"Phạm Thành Công",
"Nguyễn Thị Ngọc Chi",
"Phạm Thị Dịu",
"Trần Minh Khánh",
"Nguyễn Ngọc Quỳnh Như",
"Chế Thụy Phương Thanh",
"Nguyễn Thị Vân Anh",
"Lê Đại Hải Dương",
"Đoàn Thị Ngọc Hoa",
"La Minh Trí",
"Nguyễn Thị Phương Trâm",
"Phạm Thị Thảo",
"Thân Thị Tươi",
"Nguyễn Thị Thúy Vi",
"Nguyễn Văn Linh",
"Lê Tuấn Anh",
"Nguyễn Thanh Huân",
"Cao Hoàng Trung Hiệp",
"Phùng Văn Lâm",
"Phan Nguyễn Bảo Ngân",
"Vy Văn Quỳnh",
"Lý Đình Quyết",
"Trương Văn Sáng",
"Võ Văn Thành",
"Lê Thị Lan Trinh",
"Nguyễn Chí Thanh",
"Nguyễn Văn Thắng",
"Lê Quốc Ý",
"Hoàng Đức Duy",

        );
    }


    private function randomChuyenNganh()
    {
        $items = array(
            'Quản lý giáo dục',
'Sư phạm Sinh học',
'Sư phạm Ngữ văn',
'Khoa học Máy tính',
'Kỹ thuật Máy tính',
'Kỹ thuật Điện',
'Kỹ thuật Cơ khí',
'Kỹ thuật Xây dựng',
'Công nghệ sinh học',
'Quản lý công nghiệp',
'Kỹ thuật cơ điện tử',
'Kỹ thuật tàu thủy',
'Kỹ thuật cơ sở hạ tầng',
'Kỹ thuật hệ thống công nghiệp',
        );
        return $items[array_rand($items)];
    }
    private function randomDaiHoc(){
        $items = array(
            'Đại học Bách khoa',
            'Đại học Kinh tế',
            'Đại học Ngoại ngữ',
            'Đại học Sư phạm',
            'Đại học Sư phạm Kỹ thuật',
            'Cao đẳng Du lịch Đà Nẵng',
            'Cao đẳng Thương mại Đà Nẵng',
            'Cao đẳng Nghề số 5',
            'Trường Kinh tế',
            'Đông Á',
            'FPT'
        );
        return $items[array_rand($items)];
    }
}
