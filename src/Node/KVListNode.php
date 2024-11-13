<?php

namespace Struzik\EPPClient\Extension\IdDigital\KeyValue\Node;

use Struzik\EPPClient\Exception\InvalidArgumentException;
use Struzik\EPPClient\Request\RequestInterface;

class KVListNode
{
    public static function create(RequestInterface $request, \DOMElement $parentNode, string $name): \DOMElement
    {
        if ($name === '') {
            throw new InvalidArgumentException('Invalid parameter "name".');
        }

        $node = $request->getDocument()->createElement('kv:kvlist');
        $node->setAttribute('name', $name);
        $parentNode->appendChild($node);

        return $node;
    }
}
