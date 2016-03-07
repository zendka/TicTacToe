<form>
    <?php foreach ($state as $position => $mark) : ?>
        <input type="text" size="1" name="state[<?php print $position; ?>]"
               value="<?php print $state[$position]; ?>" <?php if (!$available[$position]) print 'readonly'; ?>>
    <?php endforeach; ?>
    <input type="Submit" value="Submit">
</form>
