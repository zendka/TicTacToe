<form>
    <?php foreach ($grid as $position => $mark) : ?>
        <input type="text" size="1" name="grid[<?php print $position; ?>]"
               value="<?php print $grid[$position]; ?>" <?php if (!$available[$position]) print 'readonly'; ?>>
    <?php endforeach; ?>
    <input type="hidden" name="gameType" value="<?php print $gameType; ?>">
    <input type="Submit" value="Submit">
</form>
