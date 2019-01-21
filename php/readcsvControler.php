
<?php
if (isset($_FILES['csvupload']['name']) && $_FILES['csvupload']['name'] != '') {
    try {
        if ($_FILES['csvupload']['type'] == "application/vnd.ms-excel") {
            $path = str_replace('php/content/readcsv.php', '', $_SERVER['SCRIPT_FILENAME']) . "csv/";
            $fname = $_FILES['csvupload']['name'];
            move_uploaded_file($_FILES['csvupload']['tmp_name'], $path . $fname);
        }
    } catch (Exception $e) {
        echo 'Error Message: ' . $e->getMessage();
    }
}

if (!file_exists($path . "" . $fname) || !is_readable($path . "" . $fname)) {
    return false;
}
$header = null;
$data = array();
$country = array();
$countryCount = array();
if (($handle = fopen($path . "" . $fname, 'r')) !== false) {
    while (($row = fgetcsv($handle, 1000, ',')) !== false) {
        if (!$header) {
            $header = $row;
        } else {
            $data[] = array_combine($header, $row);
        }
    }
    fclose($handle);
}

foreach ($data as $d) {
    $country[] = $d['country'];
    $countryCount[$d['country']] = 0;
    foreach ($data as $temp) {
        if ($d['country'] == $temp['country']) {
            $countryCount[$d['country']] ++;
        }
    }
    $dataBase = new Db();
    $table = 'read_csv';
    $columns = 'first_name, last_name, email, gender, country';
    $value = "'" . $d['first_name'] . "', '" . $d['last_name'] . "', '" . $d['email'] . "', '" . $d['gender'] . "', '" . $d['country'] . "'";
    $insert = $dataBase->insert($table, $columns, $value);
}
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['geochart'],
        // Note: you will need to get a mapsApiKey for your project.
        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
        'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
    });
    google.charts.setOnLoadCallback(drawRegionsMap);

    function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
            ['Country', 'Popularity'],
<?php foreach ($countryCount as $key => $value) { ?>
                [<?php echo "'" . $key . "'," . $value ?>],
<?php } ?>
        ]);

        var options = {};

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
    }
</script>
<div id="regions_div" style="width: 900px; height: 500px;"></div>

<script type="text/javascript">
    google.charts.load("current", {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Element", "Density", {role: "style"}],
<?php
foreach ($countryCount as $key => $value) {
    $r = str_pad(dechex(rand(0, 255)), 2, '0', STR_PAD_LEFT);
    $g = str_pad(dechex(rand(0, 255)), 2, '0', STR_PAD_LEFT);
    $b = str_pad(dechex(rand(0, 255)), 2, '0', STR_PAD_LEFT);
    ?>
                [<?php echo "'" . $key . "'," . $value . ", '#" . $r . $g . $b . "'" ?>],
<?php } ?>
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            {calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"},
            2]);

        var options = {
            title: "Ile jest osób z poszczególnego kraju",
            width: 4000,
            height: 800,
            bar: {groupWidth: "100%"},
            legend: {position: "none"},
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
    }
</script>
<div id="columnchart_values" style="width: 2000px; height: 300px;"></div>