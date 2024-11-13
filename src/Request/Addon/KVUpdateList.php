<?php

namespace Struzik\EPPClient\Extension\IdDigital\KeyValue\Request\Addon;

use Struzik\EPPClient\Extension\IdDigital\KeyValue\Node\ItemNode;
use Struzik\EPPClient\Extension\IdDigital\KeyValue\Node\KVListNode;
use Struzik\EPPClient\Extension\IdDigital\KeyValue\Node\KVUpdateNode;
use Struzik\EPPClient\Extension\RequestAddonInterface;
use Struzik\EPPClient\Node\Common\ExtensionNode;
use Struzik\EPPClient\Request\RequestInterface;

class KVUpdateList implements RequestAddonInterface
{
    private string $name;
    private array $items;

    public function __construct(string $name, array $items)
    {
        $this->name = $name;
        $this->items = $items;
    }

    public function build(RequestInterface $request): void
    {
        $extensionNode = ExtensionNode::create($request);
        $kvUpdateNode = KVUpdateNode::create($request, $extensionNode);
        $kvListNode = KVListNode::create($request, $kvUpdateNode, $this->name);
        foreach ($this->items as $key => $value) {
            ItemNode::create($request, $kvListNode, $key, $value);
        }
    }
}
