<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FillersettingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FillersettingsTable Test Case
 */
class FillersettingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FillersettingsTable
     */
    protected $Fillersettings;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Fillersettings',
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
        $config = $this->getTableLocator()->exists('Fillersettings') ? [] : ['className' => FillersettingsTable::class];
        $this->Fillersettings = $this->getTableLocator()->get('Fillersettings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Fillersettings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\FillersettingsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\FillersettingsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
