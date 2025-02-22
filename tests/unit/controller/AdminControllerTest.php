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

namespace OCA\OwnBackup\Controller;

use OCP\Security\ISecureRandom;
use \PHPUnit\Framework\TestCase;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\TemplateResponse;


class AdminControllerTest extends TestCase {

    /** @var AdminController */
	private $controller;

	public function setUp() {
		$request = $this->getMockBuilder('OCP\IRequest')->disableOriginalConstructor()->getMock();
		$backupService = $this->getMockBuilder('OCA\OwnBackup\Service\BackupService')->disableOriginalConstructor()->getMock();

		$this->controller = new AdminController( 'ownbackup', $request, $backupService );
	}

	public function testIndex() {
		$result = $this->controller->index();

		$this->assertEquals(['backupDateHash' => NULL], $result->getParams());
		$this->assertEquals('admin', $result->getTemplateName());
		$this->assertTrue($result instanceof TemplateResponse);
	}

	public function testDoRestoreTables() {
		$timestamp = time();
		$tables = ["some_table"];

		$result = $this->controller->doRestoreTables( $timestamp, $tables );

		$this->assertEquals(['message' => '1 table(s) have been restored.'], $result->getData());
		$this->assertTrue($result instanceof DataResponse);

		$result = $this->controller->doRestoreTables( $timestamp, array() );
		$this->assertEquals(['message' => 'No tables have been restored.'], $result->getData());
	}

	public function testDoFetchTables() {
		$timestamp = time();

		$result = $this->controller->doFetchTables( $timestamp );

		$this->assertEquals(['tables' => NULL], $result->getData());
		$this->assertTrue($result instanceof DataResponse);
	}

	public function testDoCreateBackup() {
		$result = $this->controller->doCreateBackup();

		$this->assertEquals(['timestamps' => NULL, 'message' => 'A new backup has been created.'], $result->getData());
		$this->assertTrue($result instanceof DataResponse);
	}
}
