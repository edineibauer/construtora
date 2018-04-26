<div class="row color-white">
    <div class="col padding-24 c-container">
        <a href="<?= HOME ?>" class="col padding-0" id="logo">
            <img src="<?= LOGO ?>">
        </a>

        <div class="rest">
                <?php
                $read = new \ConnCrud\Read();
                $read->exeRead(PRE . "menu", "ORDER BY id ASC LIMIT 6");
                if ($read->getResult()) {
                    $tpl = new \Helpers\Template("concretur");
                    $tpl->show("menu", ["data" => $read->getResult()]);
                }
                ?>
        </div>

    </div>
</div>