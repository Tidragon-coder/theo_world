<div class="hero">
    <h1>Bienvenue sur Game World</h1>
    <p>Selectionne une section pour continuer.</p>
</div>

<div class="games">
    <?php foreach ($boardgames as $game): ?>
        <div class="game1">
            <h2><?= h($game->name) ?> || ID :<?= h($game->id) ?></h2>
            <p><?= h($game->description) ?></p>
            <button>
                <?= $this->Html->link('Jouer', ['controller' => 'Sessiongames', 'action' => 'createFromGame', $game->id], ['escapeTitle' => false]) ?>
            </button>
        </div>
    <?php endforeach; ?>
</div>

<?php if (!empty($currentGames)): ?>
    <div class="games">
        <div class="game1">
            <h2>Mes parties en cours</h2>
            <ul>
                <?php foreach ($currentGames as $entry): ?>
                    <li>
                        <?= h($entry->sessiongame->boardgame->name ?? 'Jeu') ?>
                        - Session #<?= h($entry->sessiongame_id) ?>
                        - <?php
                            $isFiller = (isset($entry->sessiongame->boardgame->name) && strtolower($entry->sessiongame->boardgame->name) === 'filler');
                            if ($isFiller) {
                                echo $this->Html->link('Reprendre', ['controller' => 'Fillersettings', 'action' => 'play', $entry->sessiongame_id]);
                            } else {
                                echo $this->Html->link('Reprendre', ['controller' => 'Mastermindsettings', 'action' => 'play', $entry->sessiongame_id]);
                            }
                            ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

<div class="menu-grid">
    <?= $this->Html->link('A propos', ['controller' => 'Pages', 'action' => 'display', 'about'], ['class' => 'card']) ?>
    <?= $this->Html->link('Jeux', ['controller' => 'Games', 'action' => 'index'], ['class' => 'card']) ?>
    <?= $this->Html->link('Contact', ['controller' => 'Contact', 'action' => 'form'], ['class' => 'card']) ?>
</div>