<?php

namespace BrevaimLabs\LaravelApprise;

use BrevaimLabs\LaravelApprise\Exceptions\NotificationFailedException;
use Illuminate\Support\Facades\Log;

class Apprise
{
    protected string $command;

    public function __construct(string $command = null)
    {
        $this->command = $command ?? config('apprise.command');
    }

    public function sendNotification(array $urls, ?string $title = null, string $body, array $options = []): array
    {
        // Validate inputs
        if (empty($urls) || empty($body)) {
            throw new \InvalidArgumentException('URLs and body are required to send a notification.');
        }

        // Build command
        $cmd = $this->command . ' ' . implode(' ', array_map('escapeshellarg', $urls));

        if ($title) {
            $cmd .= ' -t ' . escapeshellarg($title);
        }

        $cmd .= ' -b ' . escapeshellarg($body);

        // Add additional options
        foreach ($options as $option => $value) {
            $cmd .= ' --' . escapeshellarg($option) . ' ' . escapeshellarg((string)$value);
        }

        // Execute the command
        $output = [];
        $returnVar = 0;

        exec($cmd, $output, $returnVar);

        if ($returnVar !== 0) {
            Log::error('Apprise command failed: ' . implode("\n", $output));
            throw new NotificationFailedException('Failed to send notification: ' . implode("\n", $output));
        }

        return $output;
    }
}
