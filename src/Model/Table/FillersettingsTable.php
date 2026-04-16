<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Fillersettings Model
 *
 * @property \App\Model\Table\SessiongamesTable&\Cake\ORM\Association\BelongsTo $Sessiongames
 *
 * @method \App\Model\Entity\Fillersetting newEmptyEntity()
 * @method \App\Model\Entity\Fillersetting newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Fillersetting> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Fillersetting get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Fillersetting findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Fillersetting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Fillersetting> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Fillersetting|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Fillersetting saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Fillersetting>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Fillersetting>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Fillersetting>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Fillersetting> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Fillersetting>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Fillersetting>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Fillersetting>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Fillersetting> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FillersettingsTable extends Table
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

        $this->setTable('fillersettings');
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
            ->integer('nb_colonne')
            ->requirePresence('nb_colonne', 'create')
            ->notEmptyString('nb_colonne');

        $validator
            ->scalar('grid')
            ->allowEmptyString('grid');

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
