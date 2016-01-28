<?php

/**
 * Moodle component registry.
 *
 * @author Luke Carrier <luke@carrier.im>
 * @copyright 2015 Luke Carrier
 * @license GPL v3
 */

namespace ComponentRegistry\Entity;

/**
 * @Entity
 * @Table(name="components")
 */
class Component {
    /**
     * Record ID.
     *
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     *
     * @var integer
     */
    private $id;

    /**
     * Friendly name.
     *
     * @Column(type="string")
     *
     * @var integer
     */
    private $name;

    /**
     * Frankenstyle component type.
     *
     * @Column(type="string")
     *
     * @var string
     */
    private $type;

    /**
     * Frankenstyle component name.
     *
     * @Column(type="string")
     *
     * @var string
     */
    private $plugin;

    /**
     * Component versions.
     *
     * @OneToMany(targetEntity="ComponentVersion", mappedBy="")
     *
     * @var \ComponentRegistry\Entity\ComponentVersion[]
     */
    private $versions;

    public function getId() {
        return $this->id;
    }

    public function getComponent() {
        return "{$this->type}_{$this->plugin}";
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function getPlugin() {
        return $this->plugin;
    }

    public function setPlugin($plugin) {
        $this->plugin = $plugin;
        return $this;
    }

    public function addVersion(ComponentVersion $version) {
        $this->versions[] = $version;
        return $this;
    }

    public function getVersions() {
        return $this->versions;
    }
}
