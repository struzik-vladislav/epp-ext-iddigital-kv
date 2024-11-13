# Identity Digital Key-Value Extension for EPP Client
![Build Status](https://github.com/struzik-vladislav/epp-ext-iddigital-kv/actions/workflows/ci.yml/badge.svg?branch=master)
[![Latest Stable Version](https://img.shields.io/github/v/release/struzik-vladislav/epp-ext-iddigital-kv?sort=semver&style=flat-square)](https://packagist.org/packages/struzik-vladislav/epp-ext-iddigital-kv)
[![Total Downloads](https://img.shields.io/packagist/dt/struzik-vladislav/epp-ext-iddigital-kv?style=flat-square)](https://packagist.org/packages/struzik-vladislav/epp-ext-iddigital-kv/stats)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![StandWithUkraine](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/badges/StandWithUkraine.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)

Key-Value extension provided by [Identity Digital](https://www.identity.digital/). See [original documentation](https://ausregistry.github.io/doc/kv-1.0/kv-1.0.html).

Extension for [struzik-vladislav/epp-client](https://github.com/struzik-vladislav/epp-client) library.

## Usage
```php
<?php

use Psr\Log\NullLogger;
use Struzik\EPPClient\EPPClient;
use Struzik\EPPClient\Extension\IdDigital\KeyValue\KeyValueExtension;
use Struzik\EPPClient\Extension\IdDigital\KeyValue\Request\Addon\KVCreateList;
use Struzik\EPPClient\Extension\IdDigital\KeyValue\Request\Addon\KVUpdateList;
use Struzik\EPPClient\Extension\IdDigital\KeyValue\Response\Addon\KeyValueInfo;
use Struzik\EPPClient\Request\Domain\CreateDomainRequest;
use Struzik\EPPClient\Request\Domain\InfoDomainRequest;
use Struzik\EPPClient\Request\Domain\UpdateDomainRequest;

// ...

$client->pushExtension(new KeyValueExtension('urn:X-ar:params:xml:ns:kv-1.1', new NullLogger()));

// ...

/**
 * Domain create example.
 */
$request = new CreateDomainRequest($client);
$request->addExtAddon(new KVCreateList('Travel-Ack', ['TravelIndustry' => 'Y']));
$response = $client->send($request);

/**
 * Domain update example.
 */
$request = new UpdateDomainRequest($client);
$request->addExtAddon(new KVUpdateList('bn', ['abn' => '18 092 242 209', 'entityType' => 'Australian Private Company']));
$response = $client->send($request);

/**
 * Domain info example.
 */
$request = new InfoDomainRequest($client);
$request->setDomain('example.tld');
$response = $client->send($request);
$infoDomainAddon = $response->findExtAddon(KeyValueInfo::class);
if ($infoDomainAddon instanceof KeyValueInfo) {
    $list = $infoDomainAddon->getListByName('Travel-Ack');
    $travelIndustry = $list['TravelIndustry'];
}
```
