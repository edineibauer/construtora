<?php

use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Overlay\Marker;
use Ivory\GoogleMap\Helper\Builder\ApiHelperBuilder;
use Ivory\GoogleMap\Helper\Builder\MapHelperBuilder;
use Ivory\GoogleMap\Map;

define('HOMEDEV', HOME . (DEV && DOMINIO === "construtora" ? "" : "vendor/conn/construtora/"));

require_once 'inc/header.php';

extract($link->getDicionario()->getDataFullRead());
?>

    <div class="col c-slide empreendimento-video relative"
         style="background-image: url('<?= $background ?>')">
        <div class="c-slide-opaco"></div>
        <?php
        if (!empty($link_do_video)) {
            if (preg_match('/youtube\.com/i', $link_do_video)) {
                $video_server = "youtube";
                if (preg_match('/\?v=/i', $link_do_video))
                    $video_id = explode("?v=", $link_do_video)[1];
                elseif (preg_match('/youtube\.com\/embed\//i', $link_do_video))
                    $video_id = explode('"', explode("youtube.com/embed/", $link_do_video)[1])[0];

            }

            if (!empty($video_id)) {
                ?>
                <div class="col padding-128">
                    <div class="col padding-48 block align-center">
                        <button data-id="<?= $video_id ?>" data-server="<?= $video_server ?>"
                                class="btn-large btn-empreendimento-video hover-shadow color-text-grey c-slide-play radius-xxlarge color-white align-center">
                            <img src="<?= HOMEDEV ?>assets/img/play.svg" class="left padding-right" width="34px"
                                 style="width: 34px">
                            <span class="left upper font-weight-bold font-medium">Assista ao Vídeo</span>
                        </button>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>

    <div class="col">
        <div class="col c-container2 padding-48">
            <ul class="font-large color-text-grey">
                <a class="padding-medium left pointer color-hover-gray-light color-text-grey no-select"
                   href="#empreendimento-caracteristicas">Características</a>
                <li class="divisor-menu"></li>
                <a class="padding-medium left pointer color-hover-gray-light color-text-grey no-select"
                   href="#empreendimento-infra">Infraestrutura</a>
                <li class="divisor-menu"></li>
                <?php
                if (!empty($plantas)) {
                    ?>
                    <a class="padding-medium left pointer color-hover-gray-light color-text-grey no-select"
                       href="#empreendimento-planta">Plantas</a>
                    <li class="divisor-menu"></li>
                    <?php
                }
                ?>
                <a class="padding-medium left pointer color-hover-gray-light color-text-grey no-select"
                   href="#empreendimento-andamento">Acompanhe a Obra</a>
                <li class="divisor-menu"></li>
                <?php
                if (!empty($endereco['cep']) && !empty($endereco['cep']['latitude']) && !empty($endereco['cep']['latitude'])) {
                    ?>
                    <a class="padding-medium left pointer color-hover-gray-light color-text-grey no-select"
                       href="#empreendimento-localizacao">Localização</a>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>

    <div class="col" id="empreendimento-caracteristicas">
        <div class="col c-container padding-48">
            <div class="col s12 m5 padding-medium border-right">
                <div class="col align-center">
                    <img src="<?= $logo_empreendimento ?>" style="width: 260px;">
                </div>
            </div>
            <div class="col s12 m7">
                <?php
                if (!empty($caracteristicas)) {
                    foreach (["suite" => ["quartos", "suites", "master"], "garagem", "lazer"] as $c) {
                        if (is_array($c)) {
                            $tplData = ['icon' => HOMEDEV . "assets/img/empreendimento/suite.svg", "title" => ""];
                            foreach ($c as $item) {
                                if (!empty($caracteristicas[$item]))
                                    $tplData['title'] .= "{$caracteristicas[$item]} {$item} ";
                            }
                        } else {
                            $tplData = ['icon' => HOMEDEV . "assets/img/empreendimento/{$c}.svg", "title" => ""];
                            $tplData['title'] = "{$caracteristicas[$c === "lazer" ? "area_de_lazer" : $c]} " . ($c === "garagem" ? "vagas de garagem por apartamento" : ($c === "lazer" ? "pavimentos de área de lazer" : ""));
                        }
                        $tpl->show("caracteristicas_empreendimento", $tplData);
                    }
                }
                ?>
            </div>
        </div>
        <div class="col padding-32"></div>
    </div>

    <div class="col color-yellow">
        <div class="col c-container color-text-white font-light">
            <div class="col s12 m5 padding-48">
                <h2 class="col upper font-light">Empreendimento</h2>
                <p class="padding-medium">
                    <?= $descricao ?>
                </p>
            </div>
            <div class="col s12 m7 overflow-hidden padding-0">
                <img src="<?= $imagem_do_empreendimento ?>" height="370" style="height: 370px;">
            </div>
        </div>
    </div>
    <div class="col color-grey-light" id="empreendimento-infra">
        <div class="col c-container font-light">
            <div class="col s12 m5 overflow-hidden padding-0">
                <img src="<?= $infraestrutura['imagem'] ?>" height="370" style="height: 370px;">
            </div>
            <div class="col s12 m7 padding-48">
                <h2 class="col upper font-light"><?= $infraestrutura['titulo'] ?></h2>
                <p class="padding-medium">
                    <?= $infraestrutura['descricao'] ?>
                </p>
            </div>
        </div>
        <div class="col padding-48">
            <div class="c-container">
                <?php
                if (!empty($infraestrutura['categorias'])) {
                    foreach ($infraestrutura['categorias'] as $ic) {
                        $tpl->show("tag", ["icon" => HOMEDEV . "assets/img/empreendimento/correct.svg", "title" => $ic['titulo']]);
                    }
                }

                ?>
            </div>
        </div>
    </div>
<?php
if (!empty($plantas)) {
    ?>
    <div class="col color-white" id="empreendimento-planta">
        <div class="col c-container font-light padding-64">
            <div class="c-container col">
                <div class="col s12 m3 overflow-hidden padding-64">
                    <?php
                    foreach ($plantas as $i => $planta)
                        echo "<span rel='{$i}' class='col padding-large no-select" . ($i === 0 ? " color-text-yellow" : "") . " pointer planta-select margin-small font-weight-normal color-hover-gray-light upper font-xlarge color-text-grey color-hover-text-yellow'>{$planta['titulo']}</span>";
                    ?>
                </div>
                <div class="col s12 m9 padding-8">
                    <?php
                    foreach ($plantas as $i => $planta)
                        echo "<img id='planta-img-{$i}' src='{$planta['imagem']}' class='no-select planta-img" . ($i > 0 ? " hide" : "") . "'>";
                    ?>
                </div>
            </div>
            <div class="col padding-24"></div>
        </div>
    </div>

    <div class="col color-white">
        <div class="col c-container padding-tiny color-grey-medium"></div>
    </div>
    <?php
}
?>
    <section class="col color-white" id="empreendimento-andamento">
        <div class="col c-container padding-32 align-center">
            <div class="col padding-24"></div>
            <h2 class="upper padding-8">andamento da obra</h2>
            <span class="font-light font-large color-text-grey-medium">Acompanhe em que estágio esta a obra</span>
        </div>

        <div class="col c-container div-andamento-obra" data-effect="0">
            <div class='col s12 m7 padding-0'>
                <?php
                $i = 0;
                foreach ($andamento_por_setor as $c => $item) {
                    if ($i === 4)
                        echo "</div><div class='col s12 m5 padding-0'>";

                    if ($c !== "id")
                        echo "<div class='col s6 " . ($i < 4 ? "l3" : "l4") . " align-center'><canvas class='loaderCircle' rel='{$item}' id='loader-{$c}'></canvas><div class='col padding-16 upper color-text-grey-medium align-center'>" . str_replace(['_', '-'], ' ', $c) . "</div></div>";

                    $i++;
                }
                ?>
            </div>
        </div>
        <div class="col padding-16"></div>
    </section>

<?php
if (!empty($fotos_da_obra)) {
    ?>
    <section class="col color-white">
        <div class="col c-container padding-32 align-center">
            <h2 class="upper padding-8">Fotos da Obra</h2>
        </div>
        <div class="col c-container no-select">
            <div class="col left c-slide-arrow c-slide-arrow-left pointer no-select" id="prevFotoObra">
                <i class="material-icons font-jumbo no-select">keyboard_arrow_left</i>
            </div>
            <div class="col right c-slide-arrow c-slide-arrow-right pointer no-select" id="nextFotoObra">
                <i class="material-icons font-jumbo no-select">keyboard_arrow_right</i>
            </div>
            <div class="rest overflow-hidden no-select">
                <div class="slide-block-fotos">
                    <?php
                    foreach ($fotos_da_obra as $i => $foto) {
                        if ($i < 6)
                            echo "<img class='left padding-small no-select' src='" . HOME . str_replace('\\', '/', $foto['url']) . "' title='{$foto['name']}'>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col padding-48"></div>
    </section>
    <?php
}

if (!empty($endereco['cep']) && !empty($endereco['cep']['latitude']) && !empty($endereco['cep']['latitude'])) {
    ?>
    <section class="col color-yellow padding-0" id="empreendimento-localizacao">
        <div class="col background-location">
            <div class="col c-container padding-24 align-center">
                <h1 class="upper padding-4 color-text-white">Localização</h1>
                <span class="col color-text-white font-light"><?= $endereco['logradouro'] ?? "" ?></span>
                <div class="col padding-16"></div>
            </div>
        </div>

        <div class="col color-white padding-0">
            <?php
            $map = new Map();
            $map->setCenter(new Coordinate($endereco['cep']['latitude'], $endereco['cep']['longitude']));
            $map->setMapOption('zoom', 18);
            $map->setMapOption('width', 1500);
            $map->setMapOption('height', 500);
            $map->setHtmlAttribute("width", "1500");
            $map->setStylesheetOption("width", "100%");
            $map->setStylesheetOption("height", "500px");
            $map->getOverlayManager()->addMarker(new Marker(new Coordinate($endereco['cep']['latitude'], $endereco['cep']['longitude'])));

            $mapHelper = MapHelperBuilder::create()->build();
            $apiHelper = ApiHelperBuilder::create()->setKey('AIzaSyDDITs_UW4aZ-bTiS9IUlu3yzk958oW1QU')->build();

            echo $mapHelper->render($map);
            echo $apiHelper->render([$map]);
            ?>
        </div>
    </section>
    <?php
}

require_once 'inc/footer.php';
?>