<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Mastermindsettings Model
 *
 * @property \App\Model\Table\SessiongamesTable&\Cake\ORM\Association\BelongsTo $Sessiongames
 *
 * @method \App\Model\Entity\Mastermindsetting newEmptyEntity()
 * @method \App\Model\Entity\Mastermindsetting newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Mastermindsetting> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Mastermindsetting get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Mastermindsetting findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Mastermindsetting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Mastermindsetting> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Mastermindsetting|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Mastermindsetting saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Mastermindsetting>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Mastermindsetting>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Mastermindsetting>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Mastermindsetting> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Mastermindsetting>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Mastermindsetting>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Mastermindsetting>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Mastermindsetting> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MastermindsettingsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('mastermindsettings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Sessiongames', [
            'foreignKey' => 'sessiongames_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('steps')
            ->requirePresence('steps', 'create')
            ->notEmptyString('steps');

        $validator
            ->integer('sessiongames_id')
            ->notEmptyString('sessiongames_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['sessiongames_id'], 'Sessiongames'), ['errorField' => 'sessiongames_id']);

        return $rules;
    }
}
