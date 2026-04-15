<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sessiongames Model
 *
 * @property \App\Model\Table\BoardgamesTable&\Cake\ORM\Association\BelongsTo $Boardgames
 * @property \App\Model\Table\UsersessiongameTable&\Cake\ORM\Association\HasMany $Usersessiongame
 *
 * @method \App\Model\Entity\Sessiongame newEmptyEntity()
 * @method \App\Model\Entity\Sessiongame newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Sessiongame> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Sessiongame get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Sessiongame findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Sessiongame patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Sessiongame> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Sessiongame|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Sessiongame saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Sessiongame>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Sessiongame>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Sessiongame>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Sessiongame> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Sessiongame>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Sessiongame>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Sessiongame>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Sessiongame> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SessiongamesTable extends Table
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

        $this->setTable('sessiongames');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Boardgames', [
            'foreignKey' => 'Boardgames_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Usersessiongame', [
            'foreignKey' => 'sessiongame_id',
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
            ->integer('Boardgames_id')
            ->notEmptyString('Boardgames_id');

        $validator
            ->boolean('is_finish')
            ->notEmptyString('is_finish');

        $validator
            ->scalar('code')
            ->maxLength('code', 7)
            ->allowEmptyString('code');

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
        $rules->add($rules->existsIn(['Boardgames_id'], 'Boardgames'), ['errorField' => 'Boardgames_id']);

        return $rules;
    }
}
