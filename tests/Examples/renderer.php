<?php

require(realpath(__DIR__ . '/../../vendor/autoload.php'));

$lava = new \Khill\Lavacharts\Lavacharts;

if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;    // serve the requested resource as-is.
} else {
    $chartType = trim($_SERVER["REQUEST_URI"], '/');

    if ($chartType !== "") {
        $width  = 600;
        $height = floor($width*(6/19));

        $title = 'My' . ((strpos($chartType, 'To') > 0) ? 'Dashboard' : $chartType);
        $id = strtolower($title);

        if (strpos($chartType, 'Chart') > 0) {
            require_once(__DIR__ . '/Charts/' . $chartType . '.php');
        } else {
            require_once(__DIR__ . '/Dashboards/' . $chartType . '.php');
        }

        $lava->get($title)->setElementId($id);
    }
}
?>

<html>
    <head>
        <title>Lavacharts Examples</title>
    </head>
    <body>
        <div class="render" id="<?= $id ?>">
            <? if ($chartType == 'Dashboard') { ?>
                <div id="chart-div-id"></div>
                <div id="control-div-id"></div>
            <? } ?>
        </div>
            <div id="lavachart">
                <? if (strpos($chartType, 'To') > 0) { ?>
                    <div id="chart1-div-id"></div>
                    <div id="chart2-div-id"></div>
                    <div id="control1-div-id"></div>
                    <div id="control2-div-id"></div>
                <? } ?>
            </div>
<?php
    echo $lava->renderAll();
?>
    <script type="text/javascript">
        lava.ready(function() {
            console.log('Lava.js ready');

            if (typeof window.callPhantom === 'function') {
                window.callPhantom({ lava: 'ready' });
            }
        });
    </script>
    </body>
</html>

