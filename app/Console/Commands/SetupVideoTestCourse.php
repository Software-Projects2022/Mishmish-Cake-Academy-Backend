<?php

namespace App\Console\Commands;

use App\Models\Chapter;
use App\Models\Client;
use App\Models\Course;
use App\Models\CourseBooking;
use App\Models\Lesson;
use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SetupVideoTestCourse extends Command
{
    protected $signature = 'test:setup-video-course
                            {--video= : Video ID (defaults to latest completed upload)}
                            {--email=student@test.com : Student email}
                            {--password=12345678 : Student password}
                            {--phone=01000000000 : Student phone for watermark}';

    protected $description = 'Create a test course with one video chapter and approve access for a test student';

    public function handle(): int
    {
        $videoId = $this->option('video');

        $video = $videoId
            ? Video::find($videoId)
            : Video::where('status', 'completed')->orderByDesc('id')->first();

        if (!$video) {
            $this->error('No completed video found. Upload a video first or pass --video=ID');
            return 1;
        }

        $course = Course::create([
            'title' => 'Test Video Protection Course',
            'title_ar' => 'كورس تجريبي لحماية الفيديو',
            'description' => 'كورس للاختبار المحلي فقط',
            'description_ar' => 'كورس للاختبار المحلي فقط',
            'price' => '0',
            'price_after_discount' => '0',
        ]);

        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Test Lesson',
            'title_ar' => 'محاضرة تجريبية',
            'duration' => '10',
        ]);

        $chapter = Chapter::create([
            'lesson_id' => $lesson->id,
            'video_id' => $video->id,
            'title' => $video->name ?: 'فيديو تجريبي',
            'title_ar' => $video->name ?: 'فيديو تجريبي',
            'duration' => '10',
            'ingredients' => '<p>كورس تجريبي — لا يوجد مقادير.</p>',
        ]);

        $email = $this->option('email');
        $client = Client::updateOrCreate(
            ['email' => $email],
            [
                'first_name' => 'طالب',
                'last_name' => 'تجريبي',
                'name' => 'طالب تجريبي',
                'phone' => $this->option('phone'),
                'password' => Hash::make($this->option('password')),
            ]
        );

        $booking = CourseBooking::updateOrCreate(
            [
                'client_id' => $client->id,
                'course_id' => $course->id,
            ],
            ['status' => 'approved']
        );

        $this->info('Test course ready.');
        $this->newLine();
        $this->table(
            ['Field', 'Value'],
            [
                ['Login', url('/login')],
                ['Course URL', url('/course/' . $course->id)],
                ['Email', $email],
                ['Password', $this->option('password')],
                ['Video', "#{$video->id} — {$video->name}"],
                ['HLS status', $video->hls_status ?: 'not started'],
                ['Chapter', "#{$chapter->id}"],
                ['Booking', $booking->status],
            ]
        );

        return 0;
    }
}
