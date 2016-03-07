<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tic-tac-toe</title>

    <link rel="stylesheet" href="style.css">

    <script>
        computerVsComputer = "<?php print $computerVsComputer; ?>";
        gameOver = "<?php print $gameOver; ?>";
        currentPlayer = "<?php print $currentPlayer; ?>";
    </script>
    <script src="script.js"></script>
</head>

<body>
    <h1>Tic-tac-toe</h1>

    <?php include('grid.tpl.php'); ?>

    <?php include('type.tpl.php'); ?>
</body>
</html>
