# Laravel Apprise Package Documentation

## Table of Contents
1. [Introduction](#introduction)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Usage](#usage)
5. [Handling Notifications](#handling-notifications)
6. [Logging](#logging)
7. [Error Handling](#error-handling)
8. [License](#license)

## Introduction

The **Laravel Apprise** package provides a seamless integration with the [Apprise](https://github.com/caronc/apprise) notification system, allowing you to send notifications through various channels effortlessly.

## Installation

To install the package, you can use Composer. Run the following command in your terminal:

```bash
composer require brevaimlabs/laravel-apprise
```

### Service Provider

The package will automatically register the service provider. However, if you're using an older version of Laravel, you might need to add the service provider to your `config/app.php` file:

```php
'providers' => [
    // ...
    BrevaimLabs\LaravelApprise\AppriseServiceProvider::class,
],
```

## Configuration

After installation, you can publish the configuration file using the Artisan command:

```bash
php artisan vendor:publish --provider="BrevaimLabs\LaravelApprise\AppriseServiceProvider"
```

This command will create a configuration file located at `config/apprise.php`, where you can customize the following settings, for more detail on the options checkout [Apprice CLI Documentation](https://github.com/caronc/apprise/wiki/CLI_Usage):

```php
return [
    /*
     * The command used to invoke the Apprise CLI tool.
     */
    'command' => 'apprise',

    /*
     * Optional: Additional default options for the Apprise command.
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
     */
    'options' => [],
];
```

### Example Configuration

```php
return [
    'command' => 'apprise',
    'options' => [
        'storage-path' => '/path/to/storage',
        'notification-type' => 'success',
        'dry-run' => false,
    ],
];
```

## Usage

To use the package, you can inject the `Apprise` class into your controllers or service classes. Here’s a simple example of how to send a notification:

### Sending a Notification

```php
use BrevaimLabs\LaravelApprise\Apprise;

// Create an instance of the Apprise class
$apprise = new Apprise();

// Define your notification parameters
$urls = ['http://example.com/notify'];
$title = 'Notification Title';
$body = 'This is a test notification';
$userOptions = [
    'notification-type' => 'success',
    'dry-run' => true, // Optional: Perform a dry run without sending notifications
];

// Send the notification
try {
    $result = $apprise->sendNotification($urls, $title, $body, $userOptions);
    echo 'Notification sent successfully: ' . json_encode($result);
} catch (\BrevaimLabs\LaravelApprise\Exceptions\NotificationFailedException $e) {
    echo 'Error: ' . $e->getMessage();
}

```

## Error Handling

When sending notifications, if any required parameters are missing or if the Apprise command fails, the package will throw an exception. You can handle these exceptions as shown in the usage example.

### Exception Types

- **InvalidArgumentException**: Thrown when required parameters (URLs and body) are missing.
- **NotificationFailedException**: Thrown when the Apprise command fails to execute.

## License

This package is licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.


## Contributioning

Contributions are welcome! If you want to contribute to this project, please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes and commit them (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Open a pull request.

Please ensure that your code adheres to the coding standards of the project and includes appropriate tests.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/BrevaimLabs/laravel-apprise/tags).

## Acknowledgements

- [Apprise](https://github.com/caronc/apprise) for providing the CLI tool for notifications.
- [Laravel](https://laravel.com/) for an excellent PHP framework.
