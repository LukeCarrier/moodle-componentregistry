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
 * @Table(name="component_versions")
 */
class ComponentVersion {
    // TODO: maturity constants

    /**
     * VCS system: Git.
     *
     * @var integer
     */
    const VCS_GIT = 1;

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
     * Component ID.
     *
     * @Column(name="component_id", type="integer")
     *
     * @var integer
     */
    private $componentId;

    /**
     * Conponent version number.
     *
     * @Column(type="integer")
     *
     * @var integer
     */
    private $version;

    /**
     * Friendly release name.
     *
     * @Column(type="string")
     *
     * @var integer
     */
    private $release;

    /**
     * Release maturity.
     *
     * @Column(type="integer")
     *
     * @var integer
     */
    private $maturity;

    /**
     * VCS system.
     *
     * @Column(name="vcs_system", type="integer")
     *
     * @var integer
     */
    private $vcsSystem;

    /**
     * VCS URL.
     *
     * @Column(name="vcs_url", type="string")
     *
     * @var string
     */
    private $vcsUrl;

    /**
     * VCS branch.
     *
     * @Column(name="vcs_branch", type="string")
     *
     * @var string
     */
    private $vcsBranch;

    /**
     * VCS tag.
     *
     * @Column(name="vcs_tag", type="string")
     *
     * @var string
     */
    private $vcsTag;

    /**
     * Owning component.
     *
     * @ManyToOne(targetEntity="Component")
     *
     * @var \ComponentRegistry\Entity\Component
     */
    private $component;

    public function getId() {
        return $this->id;
    }

    public function getComponentId() {
        return $this->componentId;
    }

    public function setComponentId($componentId) {
        $this->componentId = $componentId;
        return $this;
    }

    public function getVersion() {
        return $this->version;
    }

    public function setVersion($version) {
        $this->version = $version;
        return $this;
    }

    public function getRelease() {
        return $this->release;
    }

    public function setRelease($release) {
        $this->release = $release;
        return $this;
    }

    public function getMaturity() {
        return $this->maturity;
    }

    public function setMaturity($maturity) {
        $this->maturity = $maturity;
        return $this;
    }

    public function getVcsSystem() {
        return $this->vcsSystem;
    }

    public function setVcsSystem($vcsSystem) {
        $this->vcsSystem = $vcsSystem;
        return $this;
    }

    public function getVcsUrl() {
        return $this->vcsUrl;
    }

    public function setVcsUrl($vcsUrl) {
        $this->vcsUrl = $vcsUrl;
        return $this;
    }

    public function getVcsBranch() {
        return $this->vcsBranch;
    }

    public function setVcsBranch($vcsBranch) {
        $this->vcsBranch = $vcsBranch;
        return $this;
    }

    public function getVcsTag() {
        return $this->vcsTag;
    }

    public function setVcsTag($vcsTag) {
        $this->vcsTag = $vcsTag;
        return $this;
    }

    public function setComponent($component) {
        $this->component = $component;
        return $this;
    }
}
