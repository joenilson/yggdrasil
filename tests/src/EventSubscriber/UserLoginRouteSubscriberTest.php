<?php
namespace App\EventSubscriber;

use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2018-01-02 at 16:09:15.
 */
class UserLoginRouteSubscriberTest extends TestCase
{

    /**
     * @var UserLoginRouteSubscriber
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new UserLoginRouteSubscriber;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers App\EventSubscriber\UserLoginRouteSubscriber::onKernelRequest
     * @todo   Implement testOnKernelRequest().
     */
    public function testOnKernelRequest()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers App\EventSubscriber\UserLoginRouteSubscriber::getSubscribedEvents
     * @todo   Implement testGetSubscribedEvents().
     */
    public function testGetSubscribedEvents()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
