<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersessiongameTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('usersessiongame');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Sessiongames', [
            'foreignKey' => 'sessiongame_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->integer('sessiongame_id')
            ->notEmptyString('sessiongame_id');

        $validator
            ->integer('finalscore')
            ->allowEmptyString('finalscore');

        $validator
            ->time('timesession')
            ->allowEmptyTime('timesession');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['sessiongame_id'], 'Sessiongames'), ['errorField' => 'sessiongame_id']);

        return $rules;
    }
}
