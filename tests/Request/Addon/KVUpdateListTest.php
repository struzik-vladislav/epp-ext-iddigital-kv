<?php

namespace Struzik\EPPClient\Extension\IdDigital\KeyValue\Tests\Request\Addon;

use Struzik\EPPClient\Extension\IdDigital\KeyValue\Request\Addon\KVUpdateList;
use Struzik\EPPClient\Extension\IdDigital\KeyValue\Tests\KeyValueTestCase;
use Struzik\EPPClient\Request\Domain\UpdateDomainRequest;

class KVUpdateListTest extends KeyValueTestCase
{
    public function testUpdateByIdDigitalExample(): void
    {
        $expected = <<<'EOF'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
  <command>
    <update>
      <domain:update xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
        <domain:name>example.com.au</domain:name>
      </domain:update>
    </update>
    <extension>
      <kv:update xmlns:kv="urn:X-ar:params:xml:ns:kv-1.0">
        <kv:kvlist name="bn">
          <kv:item key="abn">18 092 242 209</kv:item>
          <kv:item key="entityType">Australian Private Company</kv:item>
        </kv:kvlist>
      </kv:update>
    </extension>
    <clTRID>TEST-REQUEST-ID</clTRID>
  </command>
</epp>

EOF;
        $request = new UpdateDomainRequest($this->eppClient);
        $request->setDomain('example.com.au');
        $request->addExtAddon(new KVUpdateList('bn', ['abn' => '18 092 242 209', 'entityType' => 'Australian Private Company']));
        $request->build();

        $this->assertSame($expected, $request->getDocument()->saveXML());
    }
}
