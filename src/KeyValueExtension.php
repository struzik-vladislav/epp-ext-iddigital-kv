<?php

namespace Struzik\EPPClient\Extension\IdDigital\KeyValue;

use Psr\Log\LoggerInterface;
use Struzik\EPPClient\EPPClient;
use Struzik\EPPClient\Extension\IdDigital\KeyValue\Response\Addon\KeyValueInfo;
use Struzik\EPPClient\Extension\ExtensionInterface;
use Struzik\EPPClient\Response\ResponseInterface;

/**
 * Extension for the Identity Digital Key-Value Mapping.
 */
class KeyValueExtension implements ExtensionInterface
{
    public const NS_NAME_KV = 'kv';

    private string $uri;
    private LoggerInterface $logger;

    /**
     * @param string $uri URI of the Key-Value Mapping extension
     */
    public function __construct(string $uri, LoggerInterface $logger)
    {
        $this->uri = $uri;
        $this->logger = $logger;
    }

    public function setupNamespaces(EPPClient $client): void
    {
        $client->getExtNamespaceCollection()
            ->offsetSet(self::NS_NAME_KV, $this->uri);
    }

    public function handleResponse(ResponseInterface $response): void
    {
        if (!in_array($this->uri, $response->getUsedNamespaces(), true)) {
            $this->logger->debug(sprintf(
                'Namespace with URI "%s" does not exists in used namespaces of the response object.',
                $this->uri
            ));

            return;
        }

        $node = $response->getFirst('//kv:infData');
        if ($node !== null) {
            $this->logger->debug(sprintf('Adding add-on "%s" to the response object.', KeyValueInfo::class));
            $response->addExtAddon(new KeyValueInfo($response));
        }
    }
}
