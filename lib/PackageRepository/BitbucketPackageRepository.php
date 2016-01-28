<?php

/**
 * Moodle component registry.
 *
 * @author Luke Carrier <luke@carrier.im>
 * @copyright 2015 Luke Carrier
 * @license GPL v3
 */

namespace ComponentRegistry\PackageRepository;

use GuzzleHttp\Client;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class BitbucketPackageRepository extends AbstractPackageRepository
        implements PackageRepository {
    /**
     * Plugin list endpoint.
     */
    const PLUGIN_LIST_URL = 'https://download.moodle.org/api/1.3/pluglist.php';

    /**
     * @override \ComponentRegistry\PackageRepository\PackageRepository
     */
    public function synchronise($task) {
        $client = new Client();

        // TODO: this is really shit
        $data = $client->get(static::PLUGIN_LIST_URL)->getBody()->getContents();

        // TODO: this is even shitter
        $data = preg_replace([
            '/^{"timestamp":[0-9]+,"plugins":/',
            '/}$/',
        ], '', $data);

        $serialiser = new Serializer([
            new ArrayDenormalizer(),
            new GetSetMethodNormalizer(),
            new ObjectNormalizer(),
        ], [
            new JsonEncoder(),
        ]);
        $components = $serialiser->deserialize(
            $data, 'ComponentRegistry\Entity\Component[]', 'json');
    }
}
