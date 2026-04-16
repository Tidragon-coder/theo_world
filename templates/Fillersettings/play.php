<?php
$colors = [1 => 'red', 2 => 'blue', 3 => 'green', 4 => 'yellow', 5 => 'purple'];
$grid = $grid ?? [];
?>

<div class="hero">
    <h1>Filler</h1>
    <p>Session #<?= h($sessionId) ?></p>
    <?= $this->Html->link('Retour accueil', ['controller' => 'Boardgames', 'action' => 'index'], ['class' => 'button']) ?>
</div>

<div class="games">
    <div class="game1">
        <h2>Grille</h2>

        <?php if (isset($playerNumber) && $playerNumber !== null): ?>
            <div class="player-role">Vous êtes : <strong><?= h('J' . $playerNumber) ?></strong></div>
        <?php else: ?>
            <div class="player-role">Vous êtes : <strong>Spectateur</strong></div>
        <?php endif; ?>

    <?php if (!empty($grid) && is_array($grid)): ?>
            <div class="grid-table">
        <?php foreach ($grid as $index => $val): ?>
            <div class="square" data-pos="<?= h($index) ?>" style="background-color: <?= h($colors[(int)$val] ?? 'gray') ?>">
                <?php if ($index === array_key_first($grid)): ?>
                    <p>J2</p>
                <?php elseif ($index === array_key_last($grid)): ?>
                    <p>J1</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
            </div>
        <?php elseif (empty($grid)): ?>
            <p>Aucune grille disponible.</p>
    <?php endif; ?>

        <?php
            // pour les couleurs
            $availableColors = [];
            $firstKey = !empty($grid) ? array_key_first($grid) : null;
            $lastKey = !empty($grid) ? array_key_last($grid) : null;
            $refIndex = null;
            if (isset($playerNumber) && $playerNumber !== null && $firstKey !== null && $lastKey !== null) {
                $refIndex = ($playerNumber === 2) ? $firstKey : $lastKey;
                if ($refIndex !== null) {
                    $row = intdiv($refIndex, 8);
                    $col = $refIndex % 8;
                    $neighbors = [];
                    if ($row > 0) $neighbors[] = $refIndex - 8;
                    if ($row < 7) $neighbors[] = $refIndex + 8;
                    if ($col > 0) $neighbors[] = $refIndex - 1;
                    if ($col < 7) $neighbors[] = $refIndex + 1;

                    // exclude J2's color (value)
                    $j2ColorVal = null;
                    if ($firstKey !== null && isset($grid[$firstKey])) {
                        $j2ColorVal = (int)$grid[$firstKey];
                    }

                    foreach ($neighbors as $n) {
                        if (isset($grid[$n])) {
                            $val = (int)$grid[$n];
                            if ($val && $val !== $j2ColorVal) {
                                $availableColors[$val] = true; // store numeric keys
                            }
                        }
                    }
                }
            }
        ?>
        <div class="couleurs-code">
            <h2>Couleurs à choisir</h2>
            <div class="color-palette">
                <?php if (!empty($availableColors)): ?>
                    <?php foreach (array_keys($availableColors) as $val): ?>
                        <?php $name = $colors[(int)$val] ?? 'gray'; ?>
                        <div class="color-item" data-color="<?= h($val) ?>">
                            <span class="circle" style="background-color: <?= h($name) ?>"></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucune couleur disponible autour de vous.</p>
                <?php endif; ?>
            </div>
        </div>
        <?php
            $firstColor = $colors[(int)($grid[$firstKey] ?? null)] ?? 'gray';
            $lastColor = $colors[(int)($grid[$lastKey] ?? null)] ?? 'gray';
        ?>
        <div class="player-color">
            <h2>Vos couleurs</h2>
            <div class="color-palette">
                <div class="color-item">
                    <span id="player-color-j2" class="circle" style="background-color: <?= h($firstColor) ?>"></span>
                    <p>J2</p>
                </div>
                <div class="color-item">
                    <span id="player-color-j1" class="circle" style="background-color: <?= h($lastColor) ?>"></span>
                    <p>J1</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="menu-grid">
    <?= $this->Html->link('Retour accueil', ['controller' => 'Boardgames', 'action' => 'index'], ['class' => 'card']) ?>
</div>