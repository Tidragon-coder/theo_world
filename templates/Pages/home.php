<div class="hero">
    <h1>Bienvenue sur Game World</h1>
    <p>SÃ©lectionne une section pour continuer.</p>
</div>

<div class="games">
    <?php foreach ($boardgames as $game): ?>
        <div class="game1">
            <h2><?= h($game->name) ?> || ID :<?= h($game->id) ?></h2>
            <p><?= h($game->description) ?></p>
            <button>
                <?= $this->Html->link(
                    'Jouer',
                    ['_name' => 'play:mastermind', 'gameId' => $game->id],
                    ['escapeTitle' => false]
                ) ?>
            </button>
        </div>
    <?php endforeach; ?>
</div>

<div class="menu-grid">
    <?= $this->Html->link('Ã€ propos', ['controller' => 'Pages', 'action' => 'display', 'about'], ['class' => 'card']) ?>
    <?= $this->Html->link('Jeux', ['controller' => 'Games', 'action' => 'index'], ['class' => 'card']) ?>
    <?= $this->Html->link('Contact', ['controller' => 'Contact', 'action' => 'form'], ['class' => 'card']) ?>
</div>
