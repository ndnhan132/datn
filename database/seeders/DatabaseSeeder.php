<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factory;
require_once 'vendor/autoload.php';

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
        DB::table('comments')->truncate();
        DB::table('courses')->truncate();
        DB::table('course_levels')->truncate();
        DB::table('posts')->truncate();
        DB::table('post_categories')->truncate();
        DB::table('ratings')->truncate();
        DB::table('registration_statuses')->truncate();
        DB::table('registration_types')->truncate();
        DB::table('subjects')->truncate();
        DB::table('teacher_course_registrations')->truncate();
        DB::table('images')->truncate();
        DB::table('image_types')->truncate();
        DB::table('teacher_levels')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = \Faker\Factory::create();
        DB::table('users')->insert([
            'name' => $faker->name,
            'email' => 'testadmin@gmail.com',
            'password' => bcrypt('111111'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        $teacherLevels = array('Học sinh','Sinh viên chưa ra trường', 'Sinh viên đã ra trường', 'Giáo viên', 'Giảng viên đại học');
        foreach($teacherLevels as $lv) {
            DB::table('teacher_levels')->insert([
                'display_name' => $lv,
                ]);
        }
        unset($teacherLevels);
        $teacherLevels = DB::table('teacher_levels')->get();
        DB::table('teachers')->insert([
            'name' => $faker->name,
            'email' => 'testteacher@gmail.com',
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
            'flag_is_active' => 1,
            'flag_is_checked' => 1,
        ]);
        foreach (range(0, 30) as $index) {
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
                'reference_tuition' => $faker->numberBetween($min = 10, $max = 90) . '000000',
                'year_of_birth' => $faker->numberBetween($min = 1970, $max = 2000),
                'flag_is_active' => $faker->randomElement($array = array ('0','1')),
                'flag_is_checked' => $faker->randomElement($array = array ('0','1')),
            ]);
        }
        $subjects = array(
            'Maths' => 'Toán',
            'Physical' => 'Vật lý',
            'Chemistry' => 'Hoá học',
            'Vietnamese' => 'Tiếng việt',
            'English' => 'Tiếng việt',
            'Biology' => 'Tiếng việt',
            'History' => 'Tiếng việt',
            'Geography' => 'Tiếng việt',
            'Painting' => 'Tiếng việt',
            'Chinese' => 'Tiếng việt',
            'Japanese' => 'Tiếng việt',
            'Piano' => 'Tiếng việt',
            'Organ' => 'Tiếng việt',
            'Guitar' => 'Tiếng việt',
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
        );
        foreach($courseLevels as $key => $val) {
            DB::table('course_levels')->insert([
                'name' => $key,
                'display_name' => $val,
            ]);
        }
        $registrationStatuses = array(
            'pending' => 'chờ duyệt',
            'eligible' => 'đủ điều kiện',
            'received' => 'đã nhận',
            'ineligible' => 'không đạt',
        );
        foreach($registrationStatuses as $key => $val) {
            DB::table('registration_statuses')->insert([
                'name' => $key,
                'display_name' => $val,
            ]);
        }

        $subjects = DB::table('subjects')->get();
        $courseLevels = DB::table('course_levels')->get();

        foreach (range(0, 150) as $index) {
            DB::table('courses')->insert([
                'flag_is_confirmed' => $faker->randomElement($array = array (true, false)),
                'flag_is_checked' => $faker->randomElement($array = array (true, false)),
                'code' => $faker->numberBetween($min = 00000, $max = 99999),
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
                'slug' => $faker->slug . '.html',
                'title' => $faker->text(100),
            ]);
        }

        $teachers = DB::table('teachers')->where('flag_is_active', '1')->get();
        $courses= DB::table('courses')->get();
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
    }
}
