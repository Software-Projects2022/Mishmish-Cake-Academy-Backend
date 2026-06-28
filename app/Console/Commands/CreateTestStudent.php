<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\Course;
use App\Models\CourseBooking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestStudent extends Command
{
    protected $signature = 'test:create-student
                            {--email=student@test.com : Student login email}
                            {--password=12345678 : Student login password}
                            {--phone=01000000001 : Student phone for watermark}
                            {--course=1 : Course ID with video chapters}';

    protected $description = 'Create a test student with an approved course booking for video testing';

    public function handle(): int
    {
        $email = $this->option('email');
        $password = $this->option('password');
        $phone = $this->option('phone');
        $courseId = (int) $this->option('course');

        $course = Course::with(['lessons.chapters' => fn ($q) => $q->whereNotNull('video_id')])
            ->find($courseId);

        if (!$course) {
            $this->error("Course #{$courseId} not found.");
            return 1;
        }

        $videoChapters = $course->lessons->flatMap->chapters->filter(fn ($c) => $c->video_id);

        if ($videoChapters->isEmpty()) {
            $this->error("Course #{$courseId} has no chapters linked to videos.");
            $this->line('Pick a course that has video_id set on at least one chapter.');
            return 1;
        }

        $client = Client::updateOrCreate(
            ['email' => $email],
            [
                'first_name' => 'طالب',
                'last_name' => 'تجريبي',
                'name' => 'طالب تجريبي',
                'phone' => $phone,
                'password' => Hash::make($password),
            ]
        );

        $booking = CourseBooking::updateOrCreate(
            [
                'client_id' => $client->id,
                'course_id' => $course->id,
            ],
            ['status' => 'approved']
        );

        $this->info('Test student ready for video playback.');
        $this->newLine();
        $this->table(
            ['Field', 'Value'],
            [
                ['Login URL', url('/login')],
                ['Course URL', url('/course/' . $course->id)],
                ['Email', $email],
                ['Password', $password],
                ['Phone (watermark)', $phone],
                ['Course', "#{$course->id} — {$course->title}"],
                ['Video chapters', $videoChapters->count()],
                ['Booking status', $booking->status],
            ]
        );

        return 0;
    }
}
