<?php

/**
 * Moodle component registry.
 *
 * @author Luke Carrier <luke@carrier.im>
 * @copyright 2015 Luke Carrier
 * @license GPL v3
 */

namespace ComponentRegistry\PackageRepository;

/**
 * Package repository.
 */
interface PackageRepository {
    /**
     * Synchronise with the local DB.
     *
     * @param \ComponentRegistry\Task\SynchronisePackageRepositoryTask $task
     *
     * @return mixed
     */
    public function synchronise($task);
}
