<?php

namespace App\Services;

use App\Models\Chapter;
use App\Models\Client;

class VideoAccessService
{
    public function canClientWatchChapter(?Client $client, Chapter $chapter): bool
    {
        if (!$client) {
            return false;
        }

        $chapter->loadMissing('lesson');

        if (!$chapter->lesson) {
            return false;
        }

        return $client->bookings()
            ->where('course_id', $chapter->lesson->course_id)
            ->where('status', 'approved')
            ->exists();
    }

    public function watermarkLabel(Client $client): string
    {
        $phone = trim($client->phone ?? '');
        $email = trim($client->email ?? '');

        if ($phone !== '' && $email !== '') {
            return $phone . ' | ' . $email;
        }

        if ($phone !== '') {
            return $phone;
        }

        if ($email !== '') {
            return $email;
        }

        return trim($client->name ?: ($client->first_name . ' ' . $client->last_name));
    }
}
