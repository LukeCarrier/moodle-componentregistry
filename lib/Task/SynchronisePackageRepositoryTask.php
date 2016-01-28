<?php

/**
 * Moodle component registry.
 *
 * @author Luke Carrier <luke@carrier.im>
 * @copyright 2015 Luke Carrier
 * @license GPL v3
 */

namespace ComponentRegistry\Task;
use Doctrine\ORM\EntityManager;

/**
 * Component information importer.
 */
class SynchronisePackageRepositoryTask {
    /**
     * Entity manager.
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * Package repositories.
     *
     * @var \ComponentRegistry\PackageRepository[]
     */
    protected $packageRepositories;

    /**
     * Initialiser.
     *
     * @param \ComponentRegistry\PackageRepository[] $packageRepositories
     * @param \Doctrine\ORM\EntityManager            $entityManager
     */
    public function __construct(EntityManager $entityManager,
                                $packageRepositories) {
        $this->entityManager       = $entityManager;
        $this->packageRepositories = $packageRepositories;
    }

    /**
     * Get the entity manager.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->entityManager;
    }

    /**
     * Perform the import.
     *
     * @return void
     */
    public function run() {
        foreach ($this->packageRepositories as $packageRepository) {
            $packageRepository->synchronise($this);
        }
    }
}
