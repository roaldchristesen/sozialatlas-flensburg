<?php

include("dotenv.php");

$paramDistrictId = isset($_GET['d']) ? $_GET['d'] : 1;
$paramYear = isset($_GET['y']) ? $_GET['y'] : 2021;

class District {
    public $id = -1;
    public $name = '';
    public $details = array();

    function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }


    function printInfo() {
        echo "<h2>$this->id: $this->name</h2>";
        echo "number of details: " . count($this->details) . "<br>";
        foreach ($this->details as $detail) {
            $detail->printBasicInfo();
        }
    }

    function pushDetails($data) {
        $details = new DistrictDetails();
        if ($details !== null) {
            $details->year = array_key_first($data['district_detail']);
            array_push($this->details, $details);
            $details->setByData('', $data);
        }
        else {
            // TODO: Error message
        }
    }

    function detailsByYear($year) {
        foreach ($this->details as $details) {
            if ($details->year == $year) {
                return $details;
            }
        }
        return null;
    }
}


class DistrictDetails {

    public $year = null;            // int
    public $residents = null;       // int
    public $births = null;          // int
    public $birthRate = null;       // float
    public $ageRatio = null;        // float
    public $ageToUnder18 = null;    // int
    public $age18ToUnder30 = null;  // int
    public $age30ToUnder45 = null;  // int
    public $age45ToUnder65 = null;  // int
    public $age65ToUnder80 = null;  // int
    public $age60AndAbove = null;   // int
    public $age80AndAbove = null;   // int
    public $ageToUnder7 = null;     // int
    public $age18ToUnder65 = null;  // int
    public $age65AndAbove = null;   // int

    public $employedResidents = null;               // int
    public $employmentRate = null;                  // int
    public $unemployedResidents = null;             // int
    public $percentageSgbII = null;                 // float
    public $percentageSgbIII = null;                // float
    public $percentageForeignCitizenship = null;    // float
    public $percentageFemale = null;                // float
    public $percentageAgeUnder25 = null;            // float

    public $housingBenefit = null;
    public $generalConsulting = null;
    public $noticesOfRentArrears = null;
    public $terminationRentArrears = null;
    public $terminationForConduct = null;
    public $actionForEviction = null;
    public $evictionNotice = null;
    public $evictionCarried = null;

    public $riskOfHomelessness = null;

    public $ba1565_total = null;
    public $ba1565_percentageOfTotalResidents = null;
    public $ba1565_employableWithBenefits = null;
    public $ba1565_unemploymentBenefits = null;
    public $ba1565_basicIncome = null;
    public $ba1565_assistingBenefits = null;

    public $beneficiariesSgbII = null;

    public $bc_unemployability = null;
    public $bc_employability = null;
    public $bc_percentageFemales = null;
    public $bc_percentageSingleParents = null;
    public $bc_percentageForeignCitizenship = null;

    public $inactiveBeneficiariesInHouseholds = null;

    public $bbid_male = null;
    public $bbid_female = null;
    public $bbid_age18ToUnder65 = null;
    public $bbid_age65AndAbove = null;

    public $mb_foreignCitizenship = null;   // int
    public $mb_germanCitizenship = null;    // int


    function printBasicInfo() {
        echo "year: $this->year, residents: $this->residents<br>";
    }


    function setByData($group, $data) {

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $this->setByData($key, $value);
            }
            else {

                if ($group == 'age_groups') {
                    switch ($key) {
                        case "age_to_under_18": $this->ageToUnder18 = $value; break;
                        case "age_18_to_under_30": $this->age18ToUnder30 = $value; break;
                        case "age_30_to_under_45": $this->age30ToUnder45 = $value; break;
                        case "age_45_to_under_65": $this->age45ToUnder65 = $value; break;
                        case "age_65_to_under_80": $this->age65ToUnder80 = $value; break;
                        case "age_80_and_above": $this->age80AndAbove = $value; break;
                        case "age_0_to_under_7": $this->ageToUnder7 = $value; break;
                        case "age_60_and_above": $this->age60AndAbove = $value; break;
                        case "age_18_to_under_65": $this->age18ToUnder65 = $value; break;
                        case "age_65_and_above": $this->age65AndAbove = $value; break;
                        default: "Unknown property: $key in $group<br>"; break;
                    }
                }
                else if ($group == 'unemployment_characteristics') {
                    switch ($key) {
                        case "percentage_sgb_iii": $this->percentageSgbIII = $value; break;
                        case "percentage_sgb_ii": $this->percentageSgbII = $value; break;
                        case "percentage_foreign_citizenship": $this->percentageForeignCitizenship = $value; break;
                        case "percentage_female": $this->percentageFemale = $value; break;
                        case "percentage_age_under_25": $this->percentageAgeUnder25 = $value; break;
                        default: "Unknown property: $key in $group<br>"; break;
                    }
                }
                else if ($group == 'housing_assistance') {
                    switch ($key) {
                        case "notices_of_rent_arrears": $this->noticesOfRentArrears = $value; break;
                        case "termination_rent_arrears": $this->terminationRentArrears = $value; break;
                        case "termination_for_conduct": $this->terminationForConduct = $value; break;
                        case "action_for_eviction": $this->actionForEviction = $value; break;
                        case "eviction_notice": $this->evictionNotice = $value; break;
                        case "eviction_carried": $this->evictionCarried = $value; break;
                        default: "Unknown property: $key in $group<br>"; break;
                    }
                }
                else if ($group == 'benefits_age_15_to_under_65') {
                    switch ($key) {
                        case "employable_with_benefits": $this->ba1565_employableWithBenefits = $value; break;
                        case "unemployment_benefits": $this->ba1565_unemploymentBenefits = $value; break;
                        case "basic_income": $this->ba1565_basicIncome = $value; break;
                        case "assisting_benefits": $this->ba1565_assistingBenefits = $value; break;

                        default: "Unknown property: $key in $group<br>"; break;
                    }
                }
                else if ($group == 'benefits_characteristics') {
                    switch ($key) {
                        case "beneficiaries_sgbii": $this->beneficiariesSgbII = $value; break;
                        case "unemployability": $this->bc_unemployability = $value; break;
                        case "employability": $this->bc_employability = $value; break;
                        case "percentage_females": $this->bc_percentageFemales = $value; break;
                        case "percentage_single_parents": $this->bc_percentageSingleParents = $value; break;
                        case "percentage_foreign_citizenship": $this->bc_percentageForeignCitizenship = $value; break;
                        default: "Unknown property: $key in $group<br>"; break;
                    }
                }
                else if ($group == 'basic_benefits_income') {
                    switch ($key) {
                        case "male": $this->bbid_male = $value; break;
                        case "female": $this->bbid_female = $value; break;
                        case "age_18_to_under_65": $this->bbid_age18ToUnder65 = $value; break;
                        case "age_65_and_above": $this->bbid_age65AndAbove = $value; break;
                        default: "Unknown property: $key in $group<br>"; break;
                    }
                }
                else if ($group == 'migration_background') {
                    switch ($key) {
                        case "foreign_citizenship": $this->mb_foreignCitizenship = $value; break;
                        case "german_citizenship": $this->mb_germanCitizenship = $value; break;
                        default: "Unknown property: $key in $group<br>"; break;
                    }
                }
                else {
                    // echo "<h1>$group, $key</h1>";
                }

                switch ($key) {
                    case "residents": $this->residents = $value; break;
                    case "births": $this->births = $value; break;
                    case "birth_rate": $this->birthRate = $value; break;
                    case "age_ratio": $this->ageRatio = $value; break;

                    case "employed_residents": $this->employedResidents = $value; break;
                    case "employment_rate": $this->employmentRate = $value; break;
                    case "unemployed_residents": $this->unemployedResidents = $value; break;

                    case "housing_benefit": $this->housingBenefit = $value; break;
                    case "general_consulting": $this->generalConsulting = $value; break;

                    case "risk_of_homelessness": $this->riskOfHomelessness = $value; break;

                    case "total": $this->ba1565_total = $value; break;
                    case "percentage_of_total_residents": $this->ba1565_percentageOfTotalResidents = $value; break;

                    case "inactive_beneficiaries_in_households": $this->inactiveBeneficiariesInHouseholds = $value; break;


                    default: "Unknown property: $key in $group<br>"; break;
                }
            }
        }

    }
}


class App {

    public $districts = array();
    public $currentDistrictId = null;
    public $currentDistrict = null;
    public $currentYear = null;

    public $totalResidents = null;
    public $totalBirths = null;
    public $totalMigrants = null;
    public $totalMigrantsForeignCitizenship = null;
    public $totalMigrantsGermanCitizenship = null;


    function printInfo() {
        echo "<h1>App info</h1>";
        echo "Number of districts: " . count($this->districts) . "<br>";

        foreach ($this->districts as $district) {
            $district->printInfo();
        }
    }


    function destrictCount() { return count($this->districts); }

    function setDistrictById($id) {
        if ($id < 1 || $id > $this->destrictCount()) {
            $this->currentDistrictId = null;
            $this->currentDistrict = null;
        }
        else {
            $this->currentDistrictId = $id;
            $this->currentDistrict = $this->districtById($id);
        }
    }

    function setYear($year) {
        if ($this->currentYear != $year) {
            $this->currentYear = $year;

            $this->totalResidents = 0;
            $this->totalBirths = 0;

            $this->totalMigrants = 0;
            $this->totalMigrantsForeignCitizenship = 0;
            $this->totalMigrantsGermanCitizenship = 0;

            foreach ($this->districts as $district) {
                $detail = $district->detailsByYear($year);
                if ($detail) {
                    $this->totalResidents += $detail->residents;
                    $this->totalBirths += $detail->births;

                    $this->totalMigrants += $detail->mb_foreignCitizenship + $detail->mb_germanCitizenship;
                    $this->totalMigrantsForeignCitizenship += $detail->mb_foreignCitizenship;
                    $this->totalMigrantsGermanCitizenship += $detail->mb_germanCitizenship;
                }
            }
        }
    }

    function currentDistrict() { return $this->currentDistrict; }
    function currentDistrictName() {
        return $this->currentDistrict ? $this->currentDistrict->name : '';
    }
    function currentYear() {
        return $this->currentYear;
    }

    function districtById($id, $name = null) {
        foreach ($this->districts as $district) {
            if ($district->id == $id) {
                return $district;
            }
        }
        $district = new District($id, $name);
        array_push($this->districts, $district);
        return $district;
    }
}

function htmlHBar($pos, $size, $color1, $color2) {
    if ($pos < 0)
        $pos = 0;
    else if ($pos >= 100)
        $pos = 100 - $size;
    $stop1 = $pos . "%";
    $stop2 = ($pos + $size) . "%";
    echo '<bar style="';
    echo "background: linear-gradient(90deg, $color1 $stop1, $color2 $stop1, $color2 $stop2, $color1 $stop2);";
    echo '"></bar>';    // TODO: WAI-ARIA beachten!
}

function htmlComponent1($label, $value, $total, $barOffs = -1) {
    $percent = $value / $total * 100;
    $percentText = number_format($percent, 1, ",", ".");
    $valueText = number_format($value, 0, ",", ".");
    echo "<div class=\"item\">";
    echo "<label>$label</label>";
    echo "<value>$valueText</value>";
    htmlHBar($barOffs, $percent, "#d1e4fd", "#0069f6");
    echo "<small>$percentText %</small>";
    echo "</div>";
    return $barOffs + $percent;
}


function htmlComponent2($label, $value, $decimals = 0) {
    $valueText = number_format($value, $decimals, ",", ".");
    echo "<div class=\"item\">";
    echo "<label>$label</label>";
    echo "<value>$valueText</value>";
    echo "</div>";
}

function htmlComponent3($label, $value, $decimals = 0) {
    $valueText = number_format($value, $decimals, ",", ".");
    echo "<div class=\"item\">";
    echo "<label>$label</label>";
    echo "<value>$valueText %</value>";
    echo "</div>";
}


function html1($district, $year) {

    global $app;

    echo '<div class="container">';
    if ($district) {
        $details = $district->detailsByYear($year);
        if ($details) {
            htmlComponent2("Anzahl", $details->residents);
            htmlComponent3("Anteil", $details->residents / $app->totalResidents * 100, 2);
            htmlComponent2("Stadt", $app->totalResidents);
            echo '</div>';
            echo '<div class="container">';
            $barOffs = 0;
            $barOffs = htmlComponent1("0 bis 18", $details->ageToUnder18, $details->residents, $barOffs);
            $barOffs = htmlComponent1("18 bis 30", $details->age18ToUnder30, $details->residents, $barOffs);
            $barOffs = htmlComponent1("30 bis 45", $details->age30ToUnder45, $details->residents, $barOffs);
            $barOffs = htmlComponent1("45 bis 65", $details->age45ToUnder65, $details->residents, $barOffs);
            $barOffs = htmlComponent1("65 bis 80", $details->age65ToUnder80, $details->residents, $barOffs);
            $barOffs = htmlComponent1("80+", $details->age80AndAbove, $details->residents, $barOffs);
            $barOffs = htmlComponent1("0 bis 8", $details->ageToUnder7, $details->residents, 0);
            $barOffs = htmlComponent1("60+", $details->age60AndAbove, $details->residents, 100);

            // TODO: $age18ToUnder65
            // TODO: $age65AndAbove
        }
        else {
            // TODO: Error message!
            echo "Ungültiger Details!<br>";
        }
    }
    else {
        // TODO: Error message!
        echo "Ungültiger Distrikt!<br>";
    }

    echo '</div>';
}


function html2($district, $year) {
    echo '<div class="container">';
    if ($district) {
        $details = $district->detailsByYear($year);

        if ($details) {
            $barOffs = 0;
            $barOffs = htmlComponent1("0 bis 18", $details->ageToUnder18, $details->residents, $barOffs);
            $barOffs = htmlComponent1("18 bis 65", $details->age18ToUnder65, $details->residents, $barOffs);
            $barOffs = htmlComponent1("65+", $details->age65AndAbove, $details->residents, $barOffs);
        }
        else {
            // TODO: Error message!
            echo "Ungültiger Details!<br>";
        }
    }
    else {
        // TODO: Error message!
        echo "Ungültiger Distrikt!<br>";
    }

    echo '</div>';
}


function html3($district, $year) {

    global $app;

    echo '<div class="container">';
    if ($district) {
        $details = $district->detailsByYear($year);
        if ($details) {
            $percent = $details->births / $app->totalBirths * 100;
            htmlComponent2("Anzahl", $details->births);
            htmlComponent3("Anteil", $percent, 2);
            htmlComponent3("Qoute", $details->birthRate, 1);

            // TODO: Männlich/weiblich... fehlt in der Datenbank, Daten nur für 2021 exsitent!
        }
        else {
            // TODO: Error message!
            echo "Ungültiger Details!<br>";
        }
    }
    else {
        // TODO: Error message!
        echo "Ungültiger Distrikt!<br>";
    }

    echo '</div>';
}



function html4($district, $year) {

    global $app;

    echo '<div class="container">';
    if ($district) {
        $details = $district->detailsByYear($year);
        if ($details) {
            htmlComponent2("Quotient", $details->ageRatio, 2);
        }
        else {
            // TODO: Error message!
            echo "Ungültiger Details!<br>";
        }
    }
    else {
        // TODO: Error message!
        echo "Ungültiger Distrikt!<br>";
    }

    echo '</div>';
}


function html5($district, $year) {

    // Migrationshintergrund

    global $app;

    echo '<div class="container">';
    if ($district) {
        $details = $district->detailsByYear($year);
        if ($details) {
            $total = $details->mb_foreignCitizenship + $details->mb_germanCitizenship;  // TODO: Berechnet, in Ordnung?
            $percent = $total / $details->residents * 100;  // TODO: Berechnet, in Ordnung?
            htmlComponent2("Gesamt", $total);
            htmlComponent3("Anteil", $percent, 2);

            $barOffs = 0;
            $barOffs = htmlComponent1("Ausländische staatsangh.", $details->mb_foreignCitizenship, $total, $barOffs);
            $barOffs = htmlComponent1("Deutsche staatsangh.", $details->mb_germanCitizenship, $total, $barOffs);
        }
        else {
            // TODO: Error message!
            echo "Ungültiger Details!<br>";
        }
    }
    else {
        // TODO: Error message!
        echo "Ungültiger Distrikt!<br>";
    }

    echo '</div>';
}



function html6($district, $year) {

    // Arbeitsmarkt und Beschäftigung

    global $app;

    echo '<div class="container">';
    if ($district) {
        $details = $district->detailsByYear($year);
        if ($details) {
            $others = $details->age18ToUnder65 - $details->employedResidents - $details->unemployedResidents;   // TODO: Berechnet, in Ordnung?
            $barOffs = 0;
            $barOffs = htmlComponent1("Beschäftige", $details->employedResidents, $details->age18ToUnder65, $barOffs);
            htmlComponent3("BQ<sup>*1<sup>", $details->employmentRate, 1);

            echo '</div>';
            echo '<div class="container">';

            $barOffs = htmlComponent1("Arbeitslose", $details->unemployedResidents, $details->age18ToUnder65, $barOffs);
            htmlComponent3("nur SGB III", $details->percentageSgbIII, 1);
            htmlComponent3("nur SGB II", $details->percentageSgbII, 1);
            htmlComponent3("ausländische Staatsang.", $details->percentageForeignCitizenship, 1);
            htmlComponent3("Frauen", $details->percentageFemale, 1);
            htmlComponent3("Unter 25", $details->percentageAgeUnder25, 1);

            echo '</div>';
            echo '<div class="container">';

            $barOffs = htmlComponent1("Andere", $others, $details->age18ToUnder65, $barOffs);
        }
        else {
            // TODO: Error message!
            echo "Ungültiger Details!<br>";
        }
    }
    else {
        // TODO: Error message!
        echo "Ungültiger Distrikt!<br>";
    }

    echo '</div>';
}


$app = new App();



function printIndent($indent) {
    while ($indent--) {
        echo "&nbsp;&nbsp;&nbsp;&nbsp;";
    }
}

function printArray($data, $indent = 0) {

    foreach ($data as $key => $value) {
        if (is_array($value)) {
            printIndent($indent);
            echo "$key: {<br>";
            printArray($value, $indent + 1);
            printIndent($indent);
            echo "}<br>";
        }
        else {
            printIndent($indent);
            echo "$key: $value<br>";
        }
    }
}


$use = "file";
// TODO: .env file!

if ($use = "db") {
    DotEnvEnvironment::load(".");
    $connectionString =
        "host=" . getenv('DB_HOST') .
        " port=" . getenv('DB_PORT') .
        " dbname=" . getenv('DB_NAME') .
        " user=" . getenv('DB_USER') .
        " password=" . getenv('DB_PASS');

        $pg = pg_pconnect($connectionString);

/*
    $dsn =
        "pqsql:host=" . getenv('DB_HOST') .
        ";port=" . getenv('DB_PORT') .
        ";dbname=" . getenv('DB_NAME') .
        ";user=" . getenv('DB_USER') .
        ";password=" . getenv('DB_PASS');

    $user = getenv('DB_USER');
    $password = getenv('DB_PASS');
    $db = new PDO($dsn, $user, $password);
    $sql = file_get_contents('./details.sql');
    $result = $db->exec($sql);
*/
    $sql = file_get_contents('./details.sql');
    $result = pg_query($pg, $sql);  // TODO: Aurelius: "Macht man nicht!"
    if ($result) {
        while ($row = pg_fetch_assoc($result)) {
            $data = json_decode($row['data_by_year_and_district'], true);
            $district = $app->districtById($data['district_id'], $data['district_name']);
            if ($district) {
                $district->pushDetails($data);
            }
            else {
                // TODO: Error message
            }
        }
        $app->setDistrictById($paramDistrictId);
        $app->setYear($paramYear);
    }
}

if ($use = "file") {
    $datafile = fopen("data.txt", "r") or die("Unable to open file!");
    $dataText = fread($datafile, filesize("data.txt"));
    fclose($datafile);
    $data = json_decode($dataText, true);
    // print_r($data);
    foreach ($data as $key => $value) {
    //    echo "key: $key<br>";
    //    print_r($value);
    //    echo "<br><br>";
        $district = $app->districtById($value['district_id'], $value['district_name']);
        if ($district) {
            $district->pushDetails($value);
        }
        else {
            // TODO: Error message
        }
    }

    $app->setDistrictById($paramDistrictId);
    $app->setYear($paramYear);
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Sozialatlas Dashboard - Stadt Flensburg</title>
    <meta content="Statische Daten des Sozialatlas 2022 der Stadt Flensburg" name="description">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="dashboard.css">
    <!--script src="https://cdn.tailwindcss.com"></script-->
    <!--script src="https://cdn.jsdelivr.net/npm/chart.js"></script-->
</head>

<body>
    <header>
        <div>
            <h1>Sozialatlas der Stadt Flensburg</h1>
            <p>Experimentelle Testversion, Stand 24.09.2023, oklabflensburg.de</p>
        </div>
        <div style="margin-left: auto; padding:20px;">
            <?php include("img/flensburg-stadtteile.svg"); ?>
            <!--img src="img/stadtteile.svg" style="width:700px; height:500px; margin-right:32px;"-->
            <img src="img/flensburg-logo.svg" style="width:200px; height:60px; margin-right:32px;">
            <img src="img/oklab-flensburg-logo.svg" style="width:60px; height:60px;">
        </div>
    </header>


    <div class="section">
        <a href="#" class="button">Stadtteil</a><?php echo $app->currentDistrictName();?>
    </div>
    <div class="section">
        <a href="#" class="button">Jahr</a><?php echo $app->currentYear();?>
    </div>
    <div class="section">
        <a href="#" class="button">Einstellungen</a>
    </div>


    <div class="sectionHeading">Einwohner*innen im Stadtteil</div>

    <div id="root1" class="container">
        <div class="subContainerFull _3of4">
            <?php html1($app->currentDistrict(), $app->currentYear); ?>
        </div>
        <div class="subContainerFull _1of4 graphics">
            <canvas class="chart" id="barChart1"  data-values="50,30,70,45,90,60,20,75,40,85"></canvas>
            <div id="barChart1Info"></div>
        </div>
    </div>
    <script>

        async function getDataByAPICall() {
            let response = await fetch('https://api.oklabflensburg.de/sozialatlas/v1/district/details');

            if (response.ok) {
                // if HTTP-status is 200-299
                // get the response body (the method explained below)
                // let json = await response.json();
                let text = await response.text();
                // console.log(text);
            } else {
                alert("HTTP-Error: " + response.status);
            }
        }
        // getDataByAPICall();

        const canvas = document.getElementById('barChart1');
        canvas.width = 800;
        canvas.height = 400;
        const ctx = canvas.getContext('2d');
        var barSpacing = 4;
        var barWidth = (canvas.width - barSpacing * 10) / 10;
        var maxValue = Math.max(...getValuesFromDataAttribute(canvas));
        var scaleFactor = canvas.height / maxValue;
        const barColors = [
            [209, 228, 253], [209, 228, 253], [209, 228, 253], [  0, 105, 246],
            [209, 228, 253], [209, 228, 253], [209, 228, 253], [209, 228, 253],
            [209, 228, 253], [209, 228, 253]];
        const darkeningFactor = 0.7; // Factor to darken the color
        const infoElement = document.getElementById('barChart1Info');

        canvas.addEventListener('mousemove', handleMouseHover);
        canvas.addEventListener('mouseleave', handleMouseExit);


        let hoveredBarIndex = -1;

        function drawBars() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            barWidth = (canvas.width - barSpacing * 10) / 10;
            scaleFactor = canvas.height / maxValue;

            const values = getValuesFromDataAttribute(canvas);

            // ctx.fillStyle = 'rgb(255, 0, 0)';
            // ctx.fillRect(0, 0, canvas.width, canvas.height);

            for (let i = 0; i < values.length; i++) {
                const value = values[i];
                const x = i * (barWidth + barSpacing);
                const barHeight = value * scaleFactor;
                const y = canvas.height - barHeight;
                const isHovered = i === hoveredBarIndex;

                // Calculate the color for the bar
                const color = isHovered ? darkenColor(barColors[i]) : barColors[i];

                ctx.fillStyle = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
                ctx.fillRect(x, y, barWidth, barHeight);

                if (isHovered) {
                    // Display the value of the hovered bar in the infoElement
                    // infoElement.textContent = `Hovered Value: ${values[hoveredBarIndex]}`;
                    infoElement.textContent = 'width: ' + canvasElementWidth + ', height: ' + canvasElementHeight;
                }
            }
        }

        function handleMouseHover(event) {
            const rect = canvas.getBoundingClientRect();
            const mouseX = event.clientX - rect.left;
            const mouseY = event.clientY - rect.top;

            let e = document.getElementById('barChart1');
            canvasElementWidth = e.offsetWidth;
            canvasElementHeight = e.offsetHeight;
            barWidth = (canvasElementWidth - barSpacing * 10) / 10;

            hoveredBarIndex = Math.floor(mouseX / (barWidth + barSpacing));
            drawBars();
        }

        function handleMouseExit() {
            hoveredBarIndex = -1;

            drawBars();
            infoElement.textContent = ''; // Clear the info element when mouse exits
        }

        // Helper function to get values from data attribute
        function getValuesFromDataAttribute(element) {
            const valuesAttribute = element.getAttribute('data-values');
            if (valuesAttribute) {
                return valuesAttribute.split(',').map(Number);
            }
            return [];
        }

        // Helper function to darken a color
        function darkenColor(color) {
            const r = Math.round(color[0] * darkeningFactor);
            const g = Math.round(color[1] * darkeningFactor);
            const b = Math.round(color[2] * darkeningFactor);
            return [r, g, b];
        }

        drawBars();
    </script>

    <div class="sectionHeading">Schule/Arbeit/Rente</div>

    <div id="root1" class="container">
        <div class="subContainerFull _3of4">
            <?php html2($app->currentDistrict(), $app->currentYear); ?>
        </div>
        <div class="subContainerFull _1of4 graphics">
            Grafik
        </div>
    </div>


    <div class="sectionHeading">
        Geburten
    </div>

    <div id="root1" class="container">
        <div class="subContainerFull _3of4">
            <?php html3($app->currentDistrict(), $app->currentYear); ?>
        </div>
        <div class="subContainerFull _1of4 graphics">
            Grafik
        </div>
    </div>

    <div class="sectionHeading">Altenquotient</div>

    <div id="root1" class="container">
        <div class="subContainerFull _3of4">
            <?php html4($app->currentDistrict(), $app->currentYear); ?>
        </div>
        <div class="subContainerFull _1of4 graphics">
            Grafik
        </div>
    </div>


    <div class="sectionHeading">Migrationshintergrund</div>

    <div id="root1" class="container">
        <div class="subContainerFull _3of4">
            <?php html5($app->currentDistrict(), $app->currentYear); ?>
        </div>
        <div class="subContainerFull _1of4 graphics">
            Grafik
        </div>
    </div>


    <div class="sectionHeading">Arbeitsmarkt und Beschäftigung</div>

    <div id="root1" class="container">
        <div class="subContainerFull _3of4">
            <?php html6($app->currentDistrict(), $app->currentYear); ?>
        </div>
        <div class="subContainerFull _1of4 graphics">
            Grafik
        </div>
    </div>

    <div class="sticky-bottom">
        <a href="index.php?d=1" class="button2">1</a>
        <a href="index.php?d=2" class="button2">2</a>
        <a href="index.php?d=3" class="button2">3</a>
        <a href="index.php?d=4" class="button2">4</a>
        <a href="index.php?d=5" class="button2">5</a>
        <a href="index.php?d=6" class="button2">6</a>
        <a href="index.php?d=7" class="button2">7</a>
        <a href="index.php?d=8" class="button2">8</a>
        <a href="index.php?d=9" class="button2">9</a>
        <a href="index.php?d=10" class="button2">10</a>
        <a href="index.php?d=11" class="button2">11</a>
        <a href="index.php?d=12" class="button2">12</a>
        <a href="index.php?d=13" class="button2">13</a>
    </div>

</body>
</html>
