<?php

use WordPress\Plugin\Encyclopedia\{
    Mocking_Bird
};

?>
<p>
    <?php Mocking_Bird::printProNotice('count_limit') ?>
</p>

<p>
    <a href="<?php Mocking_Bird::printProNotice('upgrade_url') ?>" target="_blank" class="button-primary"><?php Mocking_Bird::printProNotice('upgrade') ?></a>
</p>