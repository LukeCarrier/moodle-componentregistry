<?php

/**
 * Moodle component registry.
 *
 * @author Luke Carrier <luke@carrier.im>
 * @copyright 2015 Luke Carrier
 * @license GPL v3
 */

namespace ComponentRegistry\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Create base schema.
 */
class Version20160107151907 extends AbstractMigration {
    /**
     * Migrate up.
     *
     * @param \Doctrine\DBAL\Schema\Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema) {
        $table = $schema->createTable('components');
        $table->addColumn('id', 'integer');
        $table->setPrimaryKey(['id']);
        $table->addColumn('name', 'string');
        $table->addColumn('type', 'string');
        $table->addColumn('plugin', 'string');

        $table = $schema->createTable('component_versions');
        $table->addColumn('id', 'integer');
        $table->setPrimaryKey(['id']);
        $table->addColumn('component_id', 'integer');
        $table->addColumn('version', 'integer');
        $table->addColumn('release', 'string', ['notnull' => false]);
        $table->addColumn('maturity', 'integer', ['notnull' => false]);
        $table->addColumn('vcs_system', 'integer', ['notnull' => false]);
        $table->addColumn('vcs_url', 'string', ['notnull' => false]);
        $table->addColumn('vcs_branch', 'string', ['notnull' => false]);
        $table->addColumn('vcs_tag', 'string', ['notnull' => false]);
    }

    /**
     * Migrate down.
     *
     * @param \Doctrine\DBAL\Schema\Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema) {
        $schema->dropTable('components');
        $schema->dropTable('component_versions');
    }
}
