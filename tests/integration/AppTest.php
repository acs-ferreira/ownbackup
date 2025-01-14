<?php
/**
 * ownCloud - ownbackup
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Patrizio Bekerle <patrizio@bekerle.com>
 * @copyright Patrizio Bekerle 2015
 */

use OCA\OwnBackup\AppInfo\Application;
use Test\TestCase;


/**
 * This test shows how to make a small Integration Test. Query your class
 * directly from the container, only pass in mocks if needed and run your tests
 * against the database
 */
class AppTest extends TestCase {

    private $container;

    public function setUp() {
        parent::setUp();
        $app = new Application();
        $this->container = $app->getContainer();
        $app->registerSettings();
    }

    public function testAppInstalled() {
        $appManager = $this->container->query('OCP\App\IAppManager');
        $this->assertTrue($appManager->isInstalled('ownbackup'));
    }

    /**
     * Tests the OwnBackup admin section
     */
    public function testAdminSection() {
        $resultHtml = include "admin.php";
        $this->assertContains( '<div id="ownbackup">', $resultHtml );
        $this->assertContains( '<div class="section">', $resultHtml );
    }
}