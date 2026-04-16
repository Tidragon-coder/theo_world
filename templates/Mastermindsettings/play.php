<?php
$colors = [1 => 'red', 2 => 'blue', 3 => 'green', 4 => 'yellow', 5 => 'purple', 6 => 'orange', 7 => 'pink', 8 => 'black'];
$code = [];
$guesses = [];
if (!empty($steps) && is_array($steps)) {
    if (isset($steps[0]) && is_array($steps[0])) {
        $code = $steps[0];
        $guesses = array_slice($steps, 1);
    } else {
        $code = $steps;
        $guesses = [];
    }
}
?>

<div class="hero">
    <h1>Mastermind</h1>
    <p>Session #<?= h($sessionId) ?></p>
    <?= $this->Html->link('Retour accueil', ['controller' => 'Boardgames', 'action' => 'index'], ['class' => 'button']) ?>
</div>

<div class="games">

    <div class="game1">
        <div class="essais">
            <h2>Essais, 10 max</h2>
            <?php if (!empty($guesses) && is_array($guesses)): ?>
                <ul>
                    <?php foreach ($guesses as $index => $step): ?>
                        <li class="guess-row">
                            <div class="guess">
                                Essai <?= h($index + 1) ?>:
                                <?php foreach ($step as $number): ?>
                                    <span class="circle <?= h($colors[(int)$number] ?? 'gray') ?>"></span>
                                <?php endforeach; ?>
                            </div>
                            <div class="result result-grid">
                                <?php
                                $good = 0;
                                $bad = 0;
                                $none = 0;

                                // Convert values to ints for safe comparison
                                $codeInts = array_map('intval', $code);
                                $guessInts = array_map('intval', $step);

                                // First pass: count exact matches and remove them from consideration
                                $remainingCode = $codeInts;
                                $remainingGuess = $guessInts;
                                foreach ($guessInts as $pos => $val) {
                                    if (isset($remainingCode[$pos]) && $val === (int)$remainingCode[$pos]) {
                                        $good++;
                                        // Mark used
                                        $remainingCode[$pos] = null;
                                        $remainingGuess[$pos] = null;
                                    }
                                }

                                // Build counts of remaining colors in code and guess
                                $codeCounts = [];
                                foreach ($remainingCode as $v) {
                                    if ($v === null) continue;
                                    $codeCounts[$v] = ($codeCounts[$v] ?? 0) + 1;
                                }
                                $guessCounts = [];
                                foreach ($remainingGuess as $v) {
                                    if ($v === null) continue;
                                    $guessCounts[$v] = ($guessCounts[$v] ?? 0) + 1;
                                }

                                // Misplaced (bad) count is sum of min(count_in_code, count_in_guess) per color
                                foreach ($guessCounts as $color => $count) {
                                    $bad += min($count, $codeCounts[$color] ?? 0);
                                }

                                $none = 4 - $good - $bad;

                                $pegs = array_merge(
                                    array_fill(0, $good, 'good'),
                                    array_fill(0, $bad, 'bad'),
                                    array_fill(0, $none, 'none')
                                );
                                for ($i = 0; $i < 4; $i++) {
                                    $class = $pegs[$i] ?? 'none';
                                    echo '<span class="' . $class . '"></span>';
                                }
                                ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucun essai disponible.</p>
            <?php endif; ?>
        </div>
        <?php if (!$setting->sessiongame->is_finish): ?>
            <div class="selector">
                <h2>Jouer un essai</h2>

                <?= $this->Form->create(null, [
                    'url' => ['_name' => 'mastermind:addStep', 'sessionId' => $sessionId]
                ]) ?>

                <?= $this->Form->control('c1', ['type' => 'select', 'options' => $colors, 'label' => 'Colonne 1']) ?>
                <?= $this->Form->control('c2', ['type' => 'select', 'options' => $colors, 'label' => 'Colonne 2']) ?>
                <?= $this->Form->control('c3', ['type' => 'select', 'options' => $colors, 'label' => 'Colonne 3']) ?>
                <?= $this->Form->control('c4', ['type' => 'select', 'options' => $colors, 'label' => 'Colonne 4']) ?>

                <?= $this->Form->button('Valider') ?>
                <?= $this->Form->end() ?>

            </div>
        <?php else: ?>
            <div class="game-over">
                <h2>Partie terminée</h2>
                <p class="code-label">Le code était :</p>
                <div class="code">
                    <?php foreach ($code as $number): ?>
                        <span class="circle" style="background-color: <?= h($colors[(int)$number] ?? 'gray') ?>"></span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="couleurs-code">
            <h2 class="colors-label">Couleurs</h2>
            <?php if (!empty($colors) && is_array($colors)): ?>
                <?php foreach ($colors as $number => $color): ?>
                    <span class="circle" style="background-color: <?= h($colors[$number] ?? 'gray') ?>"></span>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune couleur disponible.</p>
            <?php endif; ?>
        </div>

    </div>
</div>

<div class="menu-grid">
    <?= $this->Html->link('Retour accueil', ['controller' => 'Boardgames', 'action' => 'index'], ['class' => 'card']) ?>
</div>