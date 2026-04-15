<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MastermindsettingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MastermindsettingsTable Test Case
 */
class MastermindsettingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MastermindsettingsTable
     */
    protected $Mastermindsettings;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Mastermindsettings',
        'app.Sessiongames',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Mastermindsettings') ? [] : ['className' => MastermindsettingsTable::class];
        $this->Mastermindsettings = $this->getTableLocator()->get('Mastermindsettings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Mastermindsettings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\MastermindsettingsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\MastermindsettingsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
