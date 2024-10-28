# Laravel Apprise

Laravel integration for the Apprise notification system. This package allows developers to easily send notifications from their Laravel applications using the Apprise CLI tool.

## Table of Contents
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [License](#license)
- [Contributions](#contributions)
- [Versioning](#versioning)

## Installation

You can install the package via Composer. Run the following command in your terminal:

```bash
composer require brevaimlabs/laravel-apprise
```

## Configuration

After installing the package, you can publish the configuration file using the following Artisan command:

```bash
php artisan vendor:publish --provider="BrevaimLabs\LaravelApprise\AppriseServiceProvider" --tag=config
```

This command will create a configuration file named `apprise.php` in the `config` directory of your Laravel application, allowing you to customize settings related to the Apprise notification system.

## Usage

Once the package is installed and configured, you can start sending notifications. Here are some code examples demonstrating how to use the package.

### Sending a Notification

You can send a notification by calling the `sendNotification` method on the `Apprise` service:

```php
use BrevaimLabs\LaravelApprise\Apprise;

// Create an instance of Apprise
$apprise = new Apprise();

// Send a notification
try {
    $apprise->sendNotification('Your notification body', 'Your notification title', 'info');
    echo "Notification sent successfully.";
} catch (NotificationFailedException $e) {
    echo "Failed to send notification: " . $e->getMessage();
}
```

### Customizing Notification Settings

You can customize various settings in the published `config/apprise.php` file. Adjust parameters such as the default notification type, theme, and storage options according to your needs.

```php
return [
    'default_type' => 'info', // Default notification type
    'theme' => 'default', // Default theme
    // Other configurations...
];
```

## License

This package is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.

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
