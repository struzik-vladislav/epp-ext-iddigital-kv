<?php

namespace Struzik\EPPClient\Extension\IdDigital\KeyValue\Node;

use Struzik\EPPClient\Exception\InvalidArgumentException;
use Struzik\EPPClient\Request\RequestInterface;

class ItemNode
{
    public static function create(RequestInterface $request, \DOMElement $parentNode, string $key, string $value): \DOMElement
    {
        if ($key === '') {
            throw new InvalidArgumentException('Invalid parameter "key".');
        }

        $node = $request->getDocument()->createElement('kv:item');
        $node->appendChild($request->getDocument()->createTextNode($value));
        $node->setAttribute('key', $key);
        $parentNode->appendChild($node);

        return $node;
    }
}
