<?php

namespace Struzik\EPPClient\Extension\IdDigital\KeyValue\Tests;

use Psr\Log\NullLogger;
use Struzik\EPPClient\Extension\IdDigital\KeyValue\KeyValueExtension;
use Struzik\EPPClient\Tests\EPPTestCase;

class KeyValueTestCase extends EPPTestCase
{
    public KeyValueExtension $kvExtension;

    protected function setUp(): void
    {
        parent::setUp();
        $this->kvExtension = new KeyValueExtension('urn:X-ar:params:xml:ns:kv-1.0', new NullLogger());
        $this->eppClient->pushExtension($this->kvExtension);
    }
}
