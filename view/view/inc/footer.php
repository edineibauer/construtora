<div class="col relative">
    <div class="row color-yellow">
        <div class="col padding-32 c-container2">
            <?php
            $read->exeRead(PRE . "social", "ORDER BY id DESC LIMIT 1");
            $social = $read->getResult()[0] ?? null;
            if ($social) {
                foreach (["telefone", "whatsapp", "email"] as $col) {
                    $data = [
                        "icon" => $col,
                        "titulo" => $col === "telefone" ? "Fale Conosco" : ($col === "whatsapp" ? "Fale Whatsapp" : "Atendimento por E-mail"),
                        "contato" => $social[$col]
                    ];
                    $tpl->show("contato", $data);
                }
            }
            ?>
        </div>
    </div>
    <div class="row color-grey-dark">
        <div class="col padding-32 c-container">
            <div class="col padding-64 container border-bottom">
                <div class="col s12 m3 color-text-white padding-32">
                    <a href="<?= HOME ?>" class="left">
                        <img src="<?= HOMEDEV ?>/assets/img/logo_white.png" width="180" class="c-logo-footer"
                             title="<?= SITENAME ?> - <?= SITEDESC ?>" alt="<?= SITENAME ?>">
                    </a>
                </div>
                <div class="col s12 m3 color-text-white">
                    <h4 class="upper font-large">Criciúma</h4>
                    <p class="margin-0">Rua: São Martinho (0,45km)</p>
                    <p>88805-360 Criciúma</p>
                </div>
                <div class="col s12 m3 color-text-white">
                    <h4 class="upper font-large">Contato</h4>
                    <p class="margin-0">Alguma dúvida? Entre em contato.</p>
                    <p>Envie seu Currículo</p>
                </div>
                <div class="col s12 m3 color-text-white">
                    <h4 class="upper font-large align-right">Siga-nos</h4>
                    <?php
                    if ($social) {
                        foreach (["youtube", "facebook"] as $col) {
                            $data = [
                                "title" => ucfirst($col),
                                "icon" => HOMEDEV . "/assets/img/" . ($col === "facebook" ? "facebook-logo.svg" : "youtube-logo.svg"),
                                "link" => $social[$col . "_link"]
                            ];
                            $tpl->show("iconSocial", $data);
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col padding-48 align-center color-text-white">
                &copy; Copyright <?= SITENAME ?> <?= date("Y") ?> - Todos os Direitos Reservados
            </div>
        </div>
    </div>
</div>