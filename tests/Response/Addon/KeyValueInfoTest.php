<?php

namespace Struzik\EPPClient\Extension\IdDigital\KeyValue\Tests\Response\Addon;

use Struzik\EPPClient\Extension\IdDigital\KeyValue\Response\Addon\KeyValueInfo;
use Struzik\EPPClient\Extension\IdDigital\KeyValue\Tests\KeyValueTestCase;
use Struzik\EPPClient\Response\Domain\InfoDomainResponse;

class KeyValueInfoTest extends KeyValueTestCase
{
    public function testAddonByIdDigitalExample(): void
    {
        $xml = <<<'EOF'
<?xml version="1.0" standalone="no"?>
<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
  <response>
    <result code="1000">
      <msg>Command completed successfully</msg>
    </result>
    <resData>
      <infData xmlns="urn:ietf:params:xml:ns:domain-1.0">
        <name>xn--ls8h.example</name>
        <roid>EXAMPLE1-REP</roid>
        <status s="ok" />
        <registrant>jd1234</registrant>
        <contact type="admin">sh8013</contact>
        <contact type="tech">sh8013</contact>
        <ns>
          <hostObj>ns1.example.com</hostObj>
          <hostObj>ns1.example.net</hostObj>
        </ns>
        <host>ns1.example.com</host>
        <host>ns2.example.com</host>
        <clID>ClientX</clID>
        <crID>ClientY</crID>
        <crDate>1999-04-03T22:00:00.0Z</crDate>
        <upID>ClientX</upID>
        <upDate>1999-12-03T09:00:00.0Z</upDate>
        <exDate>2005-04-03T22:00:00.0Z</exDate>
        <trDate>2000-04-08T09:00:00.0Z</trDate>
        <authInfo>
          <pw>2fooBAR</pw>
        </authInfo>
      </infData>
    </resData>
    <extension>
      <infData xmlns="urn:X-ar:params:xml:ns:kv-1.0">
        <kvlist name="bn">
          <item key="abn">18 092 242 209</item>
          <item key="entityType">Australian Private Company</item>
        </kvlist>
      </infData>
    </extension>
    <trID>
      <clTRID>ABC-12345</clTRID>
      <svTRID>54322-XYZ</svTRID>
    </trID>
  </response>
</epp>
EOF;
        $response = new InfoDomainResponse($xml, $this->eppClient->getNamespaceCollection(), $this->eppClient->getExtNamespaceCollection());
        $this->kvExtension->handleResponse($response);
        $this->assertTrue($response->isSuccess());
        $this->assertInstanceOf(KeyValueInfo::class, $response->findExtAddon(KeyValueInfo::class));

        /** @var KeyValueInfo $kvInfo */
        $kvInfo = $response->findExtAddon(KeyValueInfo::class);
        $list = $kvInfo->getListByName('bn');
        $this->assertSame(['abn' => '18 092 242 209', 'entityType' => 'Australian Private Company'], $list);
    }

    public function testAddonByIdentityDigitalExample(): void
    {
        $xml = <<<'EOF'
<?xml version="1.0" encoding="utf-8"?>
<epp xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="urn:ietf:params:xml:ns:epp-1.0 epp-1.0.xsd" xmlns="urn:ietf:params:xml:ns:epp-1.0">
  <response>
    <result code="1000">
      <msg>Command completed successfully</msg>
    </result>
    <resData>
      <domain:infData xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="urn:ietf:params:xml:ns:domain-1.0 domain-1.0.xsd" xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
      <domain:name>example.travel</domain:name>
      <domain:roid>7dde6f25ec354959b2876413cbf3aaa1-DONUTS</domain:roid>
      <domain:status s="inactive" />
      <domain:clID>Registrar01</domain:clID>
      <domain:crDate>2021-03-04T16:46:08.793Z</domain:crDate>
      <domain:upDate>2021-03-09T16:53:13.72Z</domain:upDate>
      <domain:exDate>2023-03-04T16:46:08.793Z</domain:exDate>
    </domain:infData>
    </resData>
    <extension>
      <kv11:infData xmlns:kv11="urn:X-ar:params:xml:ns:kv-1.0">
        <kv11:kvlist name="Travel-Ack">
          <kv11:item key="TravelIndustry">Y</kv11:item>
        </kv11:kvlist>
      </kv11:infData>
    </extension>
    <trID>
    <clTRID>Testcred</clTRID>
    <svTRID>f14a346a25dc474680fd2a07c2c2be2b</svTRID>
    </trID>
  </response>
</epp>
EOF;
        $response = new InfoDomainResponse($xml, $this->eppClient->getNamespaceCollection(), $this->eppClient->getExtNamespaceCollection());
        $this->kvExtension->handleResponse($response);
        $this->assertTrue($response->isSuccess());
        $this->assertInstanceOf(KeyValueInfo::class, $response->findExtAddon(KeyValueInfo::class));

        /** @var KeyValueInfo $kvInfo */
        $kvInfo = $response->findExtAddon(KeyValueInfo::class);
        $list = $kvInfo->getListByName('Travel-Ack');
        $this->assertSame(['TravelIndustry' => 'Y'], $list);
    }
}
