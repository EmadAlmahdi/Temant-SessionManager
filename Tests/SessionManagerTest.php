<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Temant\SessionManager\SessionManager;
use Temant\SessionManager\Exceptions\SessionNotStartedException;
use Temant\SessionManager\Exceptions\SessionStartedException;
use Temant\SessionManager\SessionManagerInterface;

class SessionManagerTest extends TestCase
{
    protected SessionManagerInterface $sessionManager;

    protected function setUp(): void
    {
        $this->sessionManager = new SessionManager();
    }

    protected function tearDown(): void
    {
        if ($this->sessionManager->isActive()) {
            $this->sessionManager->destroy();
        }
    }

    public function testIsActive(): void
    {
        $this->assertFalse($this->sessionManager->isActive());
        $this->sessionManager->start();
        $this->assertTrue($this->sessionManager->isActive());
        $this->sessionManager->destroy();
    }

    public function testSetName(): void
    {
        $this->sessionManager->setName('MY_SESSION');
        $this->assertSame('MY_SESSION', session_name());
    }

    public function testSetNameThrowsExceptionIfSessionStarted(): void
    {
        $this->expectException(SessionStartedException::class);
        $this->sessionManager->start();
        $this->sessionManager->setName('MY_SESSION');
        $this->sessionManager->destroy();
    }

    public function testStart(): void
    {
        $this->assertTrue($this->sessionManager->start());
        $this->assertTrue($this->sessionManager->isActive());
    }

    public function testStartThrowsExceptionIfSessionStarted(): void
    {
        $this->expectException(SessionStartedException::class);
        $this->sessionManager->start();
        $this->sessionManager->start();
    }

    public function testGetThrowsExceptionIfSessionStarted(): void
    {
        $this->expectException(SessionNotStartedException::class);
        $this->sessionManager->get('key');
    }

    public function testSetThrowsExceptionIfSessionStarted(): void
    {
        $this->expectException(SessionNotStartedException::class);
        $this->sessionManager->set('key', 'value');
    }

    public function testSetGet(): void
    {
        $this->sessionManager->start();
        $this->sessionManager->set('key', 'value');
        $this->assertSame('value', $this->sessionManager->get('key'));
    }

    public function testGetReturnsNullIfNotExist(): void
    {
        $this->sessionManager->start();
        $this->assertNull($this->sessionManager->get('nonexistent'));
    }

    public function testAll(): void
    {
        $this->sessionManager->start();
        $this->sessionManager->set('key1', 'value1');
        $this->sessionManager->set('key2', 'value2');
        $this->assertSame(['key1' => 'value1', 'key2' => 'value2'], $this->sessionManager->all());
    }

    public function testAllThrowsExceptionIfSessionStarted(): void
    {
        $this->expectException(SessionNotStartedException::class);
        $this->sessionManager->all();
    }

    public function testHas(): void
    {
        $this->assertFalse($this->sessionManager->has('key'));
        $this->sessionManager->start();
        $this->sessionManager->set('key', 'value');
        $this->assertTrue($this->sessionManager->has('key'));
        $this->assertFalse($this->sessionManager->has('nonexistent'));
    }

    public function testRemove(): void
    {
        $this->sessionManager->start();
        $this->sessionManager->set('key', 'value');
        $this->sessionManager->remove('key');
        $this->assertFalse($this->sessionManager->has('key'));
    }

    public function testRemoveThrowsExceptionIfSessionStarted(): void
    {
        $this->expectException(SessionNotStartedException::class);
        $this->sessionManager->remove('key');
    }

    public function testRegenerate(): void
    {
        $this->sessionManager->start();
        $oldId = session_id();
        $this->sessionManager->regenerate();
        $this->assertNotSame($oldId, session_id());
    }

    public function testRegenerateThrowsExceptionIfSessionNotStarted(): void
    {
        $this->expectException(SessionNotStartedException::class);
        $this->sessionManager->regenerate();
    }

    public function testDestroy(): void
    {
        $this->sessionManager->start();
        $this->assertTrue($this->sessionManager->destroy());
        $this->assertFalse($this->sessionManager->isActive());
    }

    public function testDestroyThrowsExceptionIfSessionNotStarted(): void
    {
        $this->expectException(SessionNotStartedException::class);
        $this->sessionManager->destroy();
    }

    public function testClose(): void
    {
        $this->sessionManager->start();
        $this->sessionManager->close();
        $this->assertFalse($this->sessionManager->isActive());
    }

    public function testCloseThrowsExceptionIfSessionNotStarted(): void
    {
        $this->expectException(SessionNotStartedException::class);
        $this->sessionManager->close();
    }

    public function testGetId(): void
    {
        $this->sessionManager->start();
        $this->assertSame(session_id(), $this->sessionManager->getId());
    }

    public function testGetIdThrowsExceptionIfSessionNotStarted(): void
    {
        $this->expectException(SessionNotStartedException::class);
        $this->sessionManager->getId();
    }

    public function testSetId(): void
    {
        $this->sessionManager->setId('newSessionId');
        $this->assertSame('newSessionId', session_id());
    }

    public function testSetIdThrowsExceptionIfSessionStarted(): void
    {
        $this->expectException(SessionStartedException::class);
        $this->sessionManager->start();
        $this->sessionManager->setId('newSessionId');
    }

    public function testSetArrayValue(): void
    {
        $this->sessionManager->start();
        $value = ['foo' => 'bar'];
        $this->sessionManager->set('arrayKey', $value);
        $this->assertSame($value, $this->sessionManager->get('arrayKey'));
    }

    public function testSetObjectValue(): void
    {
        $this->sessionManager->start();
        $value = new stdClass();
        $value->foo = 'bar';
        $this->sessionManager->set('objectKey', $value);
        $this->assertSame($value, $this->sessionManager->get('objectKey'));
    }

    public function testOverwriteExistingKey(): void
    {
        $this->sessionManager->start();
        $this->sessionManager->set('key', 'value1');
        $this->sessionManager->set('key', 'value2');
        $this->assertSame('value2', $this->sessionManager->get('key'));
    }

    public function testRemoveNonExistentKey(): void
    {
        $this->sessionManager->start();
        $this->sessionManager->remove('nonexistent');
        $this->assertFalse($this->sessionManager->has('nonexistent'));
    }

    public function testSetNameAndStartSession(): void
    {
        $this->sessionManager->setName('MY_SESSION');
        $this->sessionManager->start();
        $this->assertSame('MY_SESSION', session_name());
    }

    public function testSetIdBeforeSessionStart(): void
    {
        $this->sessionManager->setId('customSessionId');
        $this->sessionManager->start();
        $this->assertSame('customSessionId', session_id());
    }
}
