<form>
    <?php foreach ($gridState as $position => $mark) : ?>
        <input type="text" size="1" name="gridState[<?php print $position; ?>]"
               value="<?php print $gridState[$position]; ?>" <?php if (!$available[$position]) print 'readonly'; ?>>
    <?php endforeach; ?>
    <input type="hidden" name="gameType" value="<?php print $gameType; ?>">
    <input type="Submit" value="Submit">
</form>
