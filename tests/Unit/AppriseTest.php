<?php

namespace BrevaimLabs\LaravelApprise\Tests\Unit;

use BrevaimLabs\LaravelApprise\Apprise;
use BrevaimLabs\LaravelApprise\Exceptions\NotificationFailedException;
use PHPUnit\Framework\TestCase;

class AppriseTest extends TestCase
{
    private Apprise $apprise;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apprise = new Apprise();
    }

    public function testSendNotificationSuccess(): void
    {
        $this->mockExec('Notification body');

        $this->expectNotToPerformAssertions(); // Expect no exceptions to be thrown
        $this->apprise->sendNotification('Notification body', 'Notification Title', 'info');
    }

    public function testSendNotificationFailure(): void
    {
        $this->mockExecFailure();

        $this->expectException(NotificationFailedException::class);
        $this->apprise->sendNotification('Notification body', 'Notification Title', 'info');
    }

    private function mockExec(string $body): void
    {
        // Mock the exec function to simulate a successful execution
        // This requires setting up a mock for the Apprise class
        $this->apprise = $this->getMockBuilder(Apprise::class)
            ->setMethods(['exec']) // Mock the exec method
            ->getMock();

        // Set up the expectation for the exec method
        $this->apprise->expects($this->once())
            ->method('exec')
            ->with($this->stringContains($body)) // Expect it to be called with the body
            ->willReturn(0); // Simulate successful execution (return code 0)
    }

    private function mockExecFailure(): void
    {
        // Mock the exec function to simulate a failure
        $this->apprise = $this->getMockBuilder(Apprise::class)
            ->setMethods(['exec']) // Mock the exec method
            ->getMock();

        // Set up the expectation for the exec method
        $this->apprise->expects($this->once())
            ->method('exec')
            ->willReturn(1); // Simulate failure (return code not 0)
    }
}
