<?php foreach($gameTypes as $id => $description): ?>
    <p><a href="?gameType=<?php print $id; ?>"><?php print $description; ?></a></p>
<?php endforeach;
