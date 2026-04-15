<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SessiongamesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SessiongamesTable Test Case
 */
class SessiongamesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SessiongamesTable
     */
    protected $Sessiongames;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Sessiongames',
        'app.Boardgames',
        'app.Usersessiongame',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Sessiongames') ? [] : ['className' => SessiongamesTable::class];
        $this->Sessiongames = $this->getTableLocator()->get('Sessiongames', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Sessiongames);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\SessiongamesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\SessiongamesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
