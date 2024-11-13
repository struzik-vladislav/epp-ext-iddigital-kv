<?php

namespace Struzik\EPPClient\Extension\IdDigital\KeyValue\Node;

use Struzik\EPPClient\Exception\UnexpectedValueException;
use Struzik\EPPClient\Extension\IdDigital\KeyValue\KeyValueExtension;
use Struzik\EPPClient\Request\RequestInterface;

class KVUpdateNode
{
    public static function create(RequestInterface $request, \DOMElement $parentNode): \DOMElement
    {
        $namespace = $request->getClient()
            ->getExtNamespaceCollection()
            ->offsetGet(KeyValueExtension::NS_NAME_KV);
        if (!$namespace) {
            throw new UnexpectedValueException('URI of the Key-Value Mapping namespace cannot be empty.');
        }

        $node = $request->getDocument()->createElement('kv:update');
        $node->setAttribute('xmlns:kv', $namespace);
        $parentNode->appendChild($node);

        return $node;
    }
}
