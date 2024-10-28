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

This command will create a configuration file located at `config/apprise.php`, where you can customize the following settings:

```php
return [
    'command' => 'apprise', // Command to invoke the Apprise CLI tool
    'urls' => [], // Default URLs to send notifications to
    'options' => [], // Additional default options for the Apprise command
];
```

### Example Configuration

```php
return [
    'command' => 'apprise',
    'urls' => ['http://example.com'],
    'options' => ['priority' => 'high']
];
```

## Usage

To use the package, you can inject the `Apprise` class into your controllers or service classes. Here’s a simple example of how to send a notification:

### Sending a Notification

```php
use BrevaimLabs\LaravelApprise\Apprise;

class NotificationController extends Controller
{
    protected $apprise;

    public function __construct(Apprise $apprise)
    {
        $this->apprise = $apprise;
    }

    public function send()
    {
        $title = 'Notification Title';
        $body = 'This is the body of the notification.';

        try {
            $response = $this->apprise->sendNotification($title, $body);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
```

## Handling Notifications

### Command Options

You can customize the notification options by specifying them in your configuration file. The default options can also be overridden in the method call if needed.

### Example of Custom Options

```php
$options = [
    'option1' => 'value1',
    'option2' => 'value2',
];

$response = $this->apprise->sendNotification($title, $body, $options);
```

## Logging

The package uses Laravel's logging functionality to log errors when sending notifications fails. You can adjust the log level in the configuration file under `log_level`.

### Example of Logging

When a notification fails, an error will be logged like this:

```plaintext
[error] Apprise command failed: ...
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
