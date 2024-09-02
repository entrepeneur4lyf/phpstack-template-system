<?php

namespace phpStack\TemplateSystem\Tests\Unit\Core\Template;

use PHPUnit\Framework\TestCase;
use phpStack\TemplateSystem\Core\Template\HtmxRequestHandler;
use Psr\Http\Message\ResponseInterface;

class HtmxRequestHandlerTest extends TestCase
{
    private $mockResponse;

    protected function setUp(): void
    {
        $this->mockResponse = $this->createMock(ResponseInterface::class);
    }

    public function testHandleHxPushUrl()
    {
        $this->mockResponse->expects($this->once())
            ->method('withHeader')
            ->with('HX-Push-Url', '/new-url')
            ->willReturn($this->mockResponse);

        $result = HtmxRequestHandler::handle(null, $this->mockResponse, ['pushUrl' => '/new-url']);

        $this->assertSame($this->mockResponse, $result);
    }

    public function testHandleHxRedirect()
    {
        $this->mockResponse->expects($this->once())
            ->method('withHeader')
            ->with('HX-Redirect', '/redirect-url')
            ->willReturn($this->mockResponse);

        $result = HtmxRequestHandler::handle(null, $this->mockResponse, ['redirect' => '/redirect-url']);

        $this->assertSame($this->mockResponse, $result);
    }

    public function testHandleHxRefresh()
    {
        $this->mockResponse->expects($this->once())
            ->method('withHeader')
            ->with('HX-Refresh', 'true')
            ->willReturn($this->mockResponse);

        $result = HtmxRequestHandler::handle(null, $this->mockResponse, ['refresh' => true]);

        $this->assertSame($this->mockResponse, $result);
    }

    public function testHandleHxTrigger()
    {
        $triggerEvents = ['eventName' => 'eventValue'];

        $this->mockResponse->expects($this->once())
            ->method('withHeader')
            ->with('HX-Trigger', json_encode($triggerEvents))
            ->willReturn($this->mockResponse);

        $result = HtmxRequestHandler::handle(null, $this->mockResponse, ['triggerEvents' => $triggerEvents]);

        $this->assertSame($this->mockResponse, $result);
    }
}