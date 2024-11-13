<?php

namespace Struzik\EPPClient\Extension\IdDigital\KeyValue\Response\Addon;

use Struzik\EPPClient\Response\ResponseInterface;
use XPath;

/**
 * Object representation of the add-on for domain information command.
 */
class KeyValueInfo
{
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getListByName(string $name): ?array
    {
        $pattern = '//epp:epp/epp:response/epp:extension/kv:infData/kv:kvlist[@name = \'%s\']';
        $query = sprintf($pattern, XPath\quote($name));
        $node = $this->response->getFirst($query);
        if ($node === null) {
            return null;
        }

        $list = [];
        foreach ($node->childNodes as $childNode) {
            $list[$childNode->getAttribute('key')] = $childNode->nodeValue;
        }

        return $list;
    }
}
