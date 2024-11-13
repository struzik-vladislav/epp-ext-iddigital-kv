<?php

namespace Struzik\EPPClient\Extension\IdDigital\KeyValue\Tests\Request\Addon;

use Struzik\EPPClient\Extension\IdDigital\KeyValue\Request\Addon\KVCreateList;
use Struzik\EPPClient\Extension\IdDigital\KeyValue\Tests\KeyValueTestCase;
use Struzik\EPPClient\Node\Domain\DomainContactNode;
use Struzik\EPPClient\Node\Domain\DomainPeriodNode;
use Struzik\EPPClient\Request\Domain\CreateDomainRequest;
use Struzik\EPPClient\Request\Domain\Helper\HostObject;

class KVCreateListTest extends KeyValueTestCase
{
    public function testCreateByIdDigitalExample(): void
    {
        $expected = <<<'EOF'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
  <command>
    <create>
      <domain:create xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
        <domain:name>example.tld</domain:name>
        <domain:period unit="y">2</domain:period>
        <domain:ns>
          <domain:hostObj>ns1.example.net</domain:hostObj>
          <domain:hostObj>ns2.example.net</domain:hostObj>
        </domain:ns>
        <domain:registrant>jd1234</domain:registrant>
        <domain:contact type="admin">sh8013</domain:contact>
        <domain:contact type="tech">sh8013</domain:contact>
        <domain:authInfo>
          <domain:pw>2fooBAR</domain:pw>
        </domain:authInfo>
      </domain:create>
    </create>
    <extension>
      <kv:create xmlns:kv="urn:X-ar:params:xml:ns:kv-1.0">
        <kv:kvlist name="bn">
          <kv:item key="abn">18 092 242 209</kv:item>
          <kv:item key="entityType">Australian Private Company</kv:item>
        </kv:kvlist>
      </kv:create>
    </extension>
    <clTRID>TEST-REQUEST-ID</clTRID>
  </command>
</epp>

EOF;
        $request = new CreateDomainRequest($this->eppClient);
        $request->setDomain('example.tld');
        $request->setPeriod(2);
        $request->setUnit(DomainPeriodNode::UNIT_YEAR);
        $request->setNameservers([
            (new HostObject())->setHost('ns1.example.net'),
            (new HostObject())->setHost('ns2.example.net'),
        ]);
        $request->setRegistrant('jd1234');
        $request->setContacts([
            DomainContactNode::TYPE_ADMIN => 'sh8013',
            DomainContactNode::TYPE_TECH => 'sh8013',
        ]);
        $request->setPassword('2fooBAR');
        $request->addExtAddon(new KVCreateList('bn', ['abn' => '18 092 242 209', 'entityType' => 'Australian Private Company']));
        $request->build();

        $this->assertSame($expected, $request->getDocument()->saveXML());
    }
}
