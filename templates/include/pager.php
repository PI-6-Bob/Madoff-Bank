<?php
$_page = $_params['p'] ?? 0;
?>
 <div class="pager">
    <?php if ($_page > 0): ?>
     <a class="btn material-icons" href="?p=<?= e($_page  - 1) ?>">chevron_left</a>
    <?php endif ?>
     <a class="btn material-icons" href="?p=<?= e(($_params['p'] ?? 0) + 1) ?>">chevron_right</a>
 </div>

