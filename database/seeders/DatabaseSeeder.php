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
            'university' => 'Đh BKDN',
            'speciality' => $faker->name,
            'teacher_level_id' => 2,
            'reference_tuition' => $faker->numberBetween($min = 10, $max = 90) . '000000',
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
            'university' =>$faker->name,
            'speciality' => $faker->name,
            'teacher_level_id' =>$faker->randomElement($teacherLevels->pluck('id')->toArray()),
            'reference_tuition' => $faker->numberBetween($min = 10, $max = 90) . '000000',
            'year_of_birth' => $faker->numberBetween($min = 1970, $max = 2000),
            'teacher_account_status_id' => '2',
            'email_verified_at' => now(),
        ]);
        foreach (range(0, 200) as $index) {
            DB::table('teachers')->insert([
                'name' => $faker->name,
                'email' => $faker->freeEmail,
                'password' => $faker->password,
                'phone'   => $faker->e164PhoneNumber,
                'address' => $faker->address,
                'is_male' => $faker->randomElement($array = array ('0','1')),
                'identity_card' => $faker->numberBetween($min = 1000, $max = 9000) * $faker->numberBetween($min = 1000, $max = 9000),
                'university' =>$faker->name,
                'speciality' => $faker->name,
                'teacher_level_id' =>$faker->randomElement($teacherLevels->pluck('id')->toArray()),
                'reference_tuition' => $faker->numberBetween($min = 100, $max = 500) . '000',
                'year_of_birth' => $faker->numberBetween($min = 1970, $max = 2000),
                'teacher_account_status_id' => $faker->randomElement($array = array (null,'1', '2', '3','1','1','1','1')),
            ]);
        }



        $subjects = array(
            'Maths' => 'Toán',
            'Physical' => 'Vật Lý',
            'Chemistry' => 'Hoá Học',
            'Vietnamese' => 'Tiếng Việt',
            'English' => 'Tiếng Anh',
            'Biology' => 'Sinh học',
            'History' => 'Lịch sử',
            'Geography' => 'Địa Lý',
            'Painting' => 'Hội Hoạ',
            'Chinese' => 'Tiếng Trung',
            'Japanese' => 'Tiếng Nhật',
            'Piano' => 'Đàn Piano',
            'Organ' => 'Đàn Organ',
            'Guitar' => 'Đàn Guitar',
        );
        foreach($subjects as $key => $val) {
            DB::table('subjects')->insert([
                'name' => $key,
                'display_name' => $val,
            ]);
        }
        $courseLevels = array(
            'childhood' => 'mầm non',
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
            'pending' => 'chưa kiểm tra',
            'eligible' => 'đủ điều kiện',
            'received' => 'đã nhận',
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

        foreach (range(0, 250) as $index) {
            $flag_is_confirmed = $faker->randomElement($array = array (true, false));
            if($flag_is_confirmed) {
                $flag_is_checked = true;
            }else{
                $flag_is_checked = $faker->randomElement($array = array (true, false));
            }
            DB::table('courses')->insert([
                'flag_is_confirmed' => $flag_is_confirmed,
                'flag_is_checked' => $flag_is_checked,
                'subject_id' => $faker->randomElement($subjects->pluck('id')->toArray()),
                'course_level_id' => $faker->randomElement($courseLevels->pluck('id')->toArray()),
                'teacher_level_id' =>$faker->randomElement($teacherLevels->pluck('id')->toArray()),
                'fullname' => $faker->name,
                'address' =>  $faker->address,
                'phone' => $faker->e164PhoneNumber,
                'email' => $faker->freeEmail,
                'time_working' => 'T2 - T7',
                'session_per_week' => $faker->numberBetween($min = 2, $max = 7),
                'time_per_session' => $faker->randomElement($array = array ('60', '90','120')),
                'num_of_student' => $faker->numberBetween($min = 1, $max = 3),
                'tuition_per_month' => $faker->numberBetween($min = 1000, $max = 3000) . '000',
                'other_requirement' => $faker->text(70),
                'slug' => $faker->slug,
                'title' => $faker->text(100),
            ]);
        }

        $teachers = DB::table('teachers')->where('teacher_account_status_id', '1')->get();
        $courses= DB::table('courses')->where('flag_is_confirmed', true)->get();
        $registrationStatuses = DB::table('registration_statuses')->get();
        foreach($courses as $course) {
            foreach(range(0,2) as $index){
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
                'src' => 'https://picsum.photos/id/1005/200/300',
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

        foreach (range(0, 200) as $index) {
            DB::table('enquiries')->insert([
                'flag_is_checked' => $faker->randomElement($array = array (true, false)),
                'name' => $faker->name,
                'email' => $faker->safeEmail,
                'phone' => $faker->e164PhoneNumber,
                'title' => $faker->text(77),
                'content' => $faker->text(200),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }

    }
}
