<?php

/**
 * Moodle component registry.
 *
 * @author Luke Carrier <luke@carrier.im>
 * @copyright 2015 Luke Carrier
 * @license GPL v3
 */

namespace ComponentRegistry\PackageRepository;

use ComponentRegistry\Entity\Component;
use ComponentRegistry\Entity\ComponentVersion;
use Doctrine\ORM\EntityRepository;
use GuzzleHttp\Client;

/**
 * Moodle.org/plugins package repository.
 */
class MoodlePackageRepository extends AbstractPackageRepository
        implements PackageRepository {
    /**
     * Plugin list endpoint.
     */
    const PLUGIN_LIST_URL = 'https://download.moodle.org/api/1.3/pluglist.php';

    /**
     * @override \ComponentRegistry\PackageRepository\PackageRepository
     */
    public function synchronise($task) {
        $entityManager = $task->getEntityManager();

        $componentRepository = $entityManager->getRepository(
                'ComponentRegistry\Entity\Component');
        $versionRepository = $entityManager->getRepository(
                'ComponentRegistry\Entity\ComponentVersion');

        $client = new Client();

        // TODO: replace this with a streaming decoder
        $data = $client->get(static::PLUGIN_LIST_URL)->getBody()->getContents();
        $data = json_decode($data);

        foreach ($data->plugins as $rawComponent) {
            // Filter out source patches
            if (!strpos($rawComponent->component, '_')) {
                continue;
            }

            // Synchronise the component record
            $component = $this->synchroniseComponent(
                    $componentRepository, $rawComponent);
            $entityManager->persist($component);

            // Then all the versions
            foreach ($rawComponent->versions as $rawVersion) {
                $version = $this->synchroniseVersion(
                        $versionRepository, $component, $rawVersion);
                $entityManager->persist($version);
            }

            // Finally, synchronise migrations to the DB
            $entityManager->flush();
        }
    }

    protected function synchroniseComponent(EntityRepository $repository,
                                            \stdClass $rawComponent) {
        // Get the component name parts
        list($type, $plugin) = explode('_', $rawComponent->component, 2);

        // Find or create a component
        $component = $repository->findOneBy([
            'type'   => $type,
            'plugin' => $plugin,
        ]);
        if (!$component) {
            $component = (new Component())
                ->setType($type)
                ->setPlugin($plugin);
        }

        // Make any necessary changes
        $component
            ->setName($rawComponent->name);

        // Return it for persistence
        return $component;
    }

    protected function synchroniseVersion(EntityRepository $repository,
                                          Component $component,
                                          \stdClass $rawVersion) {
        // Find or create a version
        $version = $repository->findOneBy([
            'componentId' => $component->getId(),
            'version'     => $rawVersion->version,
        ]);
        if (!$version) {
            $version = (new ComponentVersion())
                ->setComponent($component)
                ->setVersion($rawVersion->version);
        }

        // Make any necessary changes
        $version
            ->setRelease($rawVersion->release)
            ->setMaturity($rawVersion->maturity)
            ->setVcsSystem($rawVersion->vcssystem)
            ->setVcsUrl($rawVersion->vcsrepositoryurl)
            ->setVcsBranch($rawVersion->vcsbranch)
            ->setVcsTag($rawVersion->vcstag);

        // Return it for persistence
        return $version;
    }
}
