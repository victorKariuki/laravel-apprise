<?php

namespace BrevaimLabs\LaravelApprise;

use BrevaimLabs\LaravelApprise\Exceptions\NotificationFailedException;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class Apprise
{
    protected string $command;
    protected array $defaultOptions;

    public function __construct(string $command = null, array $defaultOptions = [])
    {
        $this->command = $command ?? config('apprise.command');
        $this->defaultOptions = $defaultOptions ?: config('apprise.options'); // Get default options from config
    }

    public function sendNotification(array $urls, ?string $title = null, string $body, array $userOptions = []): array
    {
        // Merge default options with user options, giving priority to user options
        $finalOptions = array_merge($this->defaultOptions, $userOptions);
        
        // Validate inputs
        $this->validateInputs($urls, $title, $body, $finalOptions);

        // Build command
        $cmd = $this->command . ' ' . implode(' ', array_map('escapeshellarg', $urls));

        if ($title) {
            $cmd .= ' -t ' . escapeshellarg($title);
        }

        $cmd .= ' -b ' . escapeshellarg($body);

        // Add final options to command
        foreach ($finalOptions as $option => $value) {
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

        // Return structured response
        return [
            'success' => true,
            'output' => $output,
        ];
    }

    /**
     * Validate input parameters for the sendNotification method.
     *
     * @param array $urls
     * @param string|null $title
     * @param string $body
     * @param array $userOptions
     * @throws InvalidArgumentException
     */
    protected function validateInputs(array $urls, ?string $title, string $body, array $userOptions): void
    {
        // Check if URLs are provided
        if (empty($urls)) {
            throw new InvalidArgumentException('At least one URL is required to send a notification.');
        }

        // Check if body is provided
        if (empty($body)) {
            throw new InvalidArgumentException('Body is required to send a notification.');
        }

        // Optionally, check title length (e.g., max 255 characters)
        if ($title && strlen($title) > 255) {
            throw new InvalidArgumentException('Title must not exceed 255 characters.');
        }

        // Validate user-supplied options
        $this->validateUserOptions($userOptions);
    }

    /**
     * Validate user-supplied options for the sendNotification method.
     *
     * @param array $userOptions
     * @throws InvalidArgumentException
     */
    protected function validateUserOptions(array $userOptions): void
    {
        // List of supported options
        $supportedOptions = [
            'plugin-path', 
            'storage-path', 
            'storage-prune-days', 
            'storage-uid-length', 
            'storage-mode', 
            'attach', 
            'notification-type', 
            'input-format', 
            'tag', 
            'disable-async', 
            'dry-run', 
            'recursion-depth', 
            'verbose', 
            'interpret-escapes', 
            'interpret-emojis', 
            'debug'
        ];

        foreach ($userOptions as $option => $value) {
            if (!in_array($option, $supportedOptions)) {
                throw new InvalidArgumentException("Unsupported option: {$option}");
            }

            // Additional validation for specific options
            switch ($option) {
                case 'plugin-path':
                    if (!is_string($value) || empty($value)) {
                        throw new InvalidArgumentException("Option '{$option}' must be a non-empty string.");
                    }
                    break;

                case 'storage-path':
                    if (!is_string($value) || empty($value)) {
                        throw new InvalidArgumentException("Option '{$option}' must be a non-empty string.");
                    }
                    break;

                case 'storage-prune-days':
                    if (!is_int($value) || $value < 0) {
                        throw new InvalidArgumentException("Option '{$option}' must be a non-negative integer.");
                    }
                    break;

                case 'storage-uid-length':
                    if (!is_int($value) || $value <= 0) {
                        throw new InvalidArgumentException("Option '{$option}' must be a positive integer.");
                    }
                    break;

                case 'storage-mode':
                    $validModes = ['auto', 'flush', 'memory'];
                    if (!in_array($value, $validModes)) {
                        throw new InvalidArgumentException("Invalid storage mode: {$value}. Supported modes: " . implode(', ', $validModes));
                    }
                    break;

                case 'attach':
                    if (!is_array($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
                        throw new InvalidArgumentException("Option '{$option}' must be a valid URL or an array of URLs.");
                    }
                    break;

                case 'notification-type':
                    $validTypes = ['info', 'success', 'warning', 'failure'];
                    if (!in_array($value, $validTypes)) {
                        throw new InvalidArgumentException("Invalid notification type: {$value}. Supported types: " . implode(', ', $validTypes));
                    }
                    break;

                case 'input-format':
                    $validFormats = ['text', 'html', 'markdown'];
                    if (!in_array($value, $validFormats)) {
                        throw new InvalidArgumentException("Invalid input format: {$value}. Supported formats: " . implode(', ', $validFormats));
                    }
                    break;

                case 'tag':
                    if (!is_array($value) && !is_string($value)) {
                        throw new InvalidArgumentException("Option '{$option}' must be a string or an array of strings.");
                    }
                    break;

                case 'disable-async':
                case 'dry-run':
                    // No additional validation needed for boolean flags
                    if (!is_bool($value)) {
                        throw new InvalidArgumentException("Option '{$option}' must be a boolean value.");
                    }
                    break;

                case 'recursion-depth':
                    if (!is_int($value) || $value < 0) {
                        throw new InvalidArgumentException("Option '{$option}' must be a non-negative integer.");
                    }
                    break;

                case 'verbose':
                    if (!is_int($value) || $value < 0) {
                        throw new InvalidArgumentException("Option '{$option}' must be a non-negative integer indicating verbosity level.");
                    }
                    break;

                case 'interpret-escapes':
                case 'interpret-emojis':
                case 'debug':
                    // These options are flags, so we expect boolean values
                    if (!is_bool($value)) {
                        throw new InvalidArgumentException("Option '{$option}' must be a boolean value.");
                    }
                    break;
            }
        }
    }
}
