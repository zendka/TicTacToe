<?php foreach($type as $id => $description): ?>
    <p><a href=".?type=<?php print $id; ?>"><?php print $description; ?></a></p>
<?php endforeach;
