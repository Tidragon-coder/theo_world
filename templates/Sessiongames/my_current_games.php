<div class="hero">
    <h1>Mes parties en cours</h1>
</div>

<div class="games">
    <div class="game1">
        <?php if ($entries->isEmpty()): ?>
            <p>Vous n avez aucune partie en cours.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Session</th>
                        <th>Jeu</th>
                        <th>Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($entries as $entry): ?>
                        <tr>
                            <td><?= h($entry->sessiongame_id) ?></td>
                            <td><?= h($entry->sessiongame->boardgame->name ?? 'Inconnu') ?></td>
                            <td><?= h($entry->sessiongame->code ?? '-') ?></td>
                            <td>
                                <?= $this->Html->link(
                                    'Reprendre',
                                    ['_name' => 'mastermind:play', 'sessionId' => $entry->sessiongame_id]
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<div class="menu-grid">
    <?= $this->Html->link('Retour accueil', ['controller' => 'Boardgames', 'action' => 'index'], ['class' => 'card']) ?>
</div>
