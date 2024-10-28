<?php

return [
    /*
     * The command used to invoke the Apprise CLI tool.
     * This can be overridden in your application’s config/apprise.php
     * file if you need to change the default command.
     */
    'command' => 'apprise',

    /*
     * Optional: Additional default options for the Apprise command.
     * This can be overridden in your application if necessary.
     * 
     * Available options include:
     *
     * - 'plugin-path' (string): Path to custom plugins.
     * - 'storage-path' (string): Path to the storage location.
     * - 'storage-prune-days' (int): Number of days to keep stored notifications.
     * - 'storage-uid-length' (int): Length of the generated UID.
     * - 'storage-mode' (string): Mode for storage options ('auto', 'flush', 'memory').
     * - 'attach' (string|array): URLs of files to attach to notifications.
     * - 'notification-type' (string): Type of notification ('info', 'success', 'warning', 'failure').
     * - 'input-format' (string): Format of input ('text', 'html', 'markdown').
     * - 'tag' (string|array): Tags associated with the notification.
     * - 'disable-async' (bool): Disable asynchronous notifications.
     * - 'dry-run' (bool): Perform a dry run without sending notifications.
     * - 'recursion-depth' (int): Depth of recursion for certain options.
     * - 'verbose' (int): Verbosity level (0 for none, higher for more details).
     * - 'interpret-escapes' (bool): Interpret escape sequences.
     * - 'interpret-emojis' (bool): Interpret emoji codes.
     * - 'debug' (bool): Enable debug output.
     *
     * Example usage:
     * 'options' => [
     *     'storage-path' => '/path/to/storage',
     *     'notification-type' => 'success',
     *     'dry-run' => false,
     * ],
     */
    'options' => [], 
];
