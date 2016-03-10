<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tic-tac-toe</title>

    <link rel="stylesheet" href="style.css">

    <script>
        isComputerVsComputer = "<?php print $isComputerVsComputer; ?>";
        isGameOver = "<?php print $isGameOver; ?>";
        currentPlayersMark = "<?php print $currentPlayersMark; ?>";
    </script>
    <script src="script.js"></script>
</head>

<body>
    <h1>Tic-tac-toe</h1>

    <?php if(isset($message)): ?>
        <p class="message"><?php print $message; ?></p>
    <?php endif; ?>

    <?php displayGrid($game); ?>

    <?php displayGameType(); ?>
</body>
</html>
