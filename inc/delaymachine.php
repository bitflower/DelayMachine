<?
header("Content-type: text/css");

$delay = (isset($_GET['delay'])) ? floatval($_GET['delay']) : 0.2;
$range = (isset($_GET['range'])) ? floatval($_GET['range']) : 20;

$transitionDelay = (isset($_GET['transitionDelay'])) ? filter_var($_GET['transitionDelay'], FILTER_VALIDATE_BOOLEAN) : true;
$animationDelay = (isset($_GET['animationDelay'])) ? filter_var($_GET['animationDelay'], FILTER_VALIDATE_BOOLEAN) : true;

$linearRatio = (isset($_GET['linearRatio'])) ? floatval($_GET['linearRatio']) : 0.9;
$linearRatioLimit = (isset($_GET['linearRatioLimit'])) ? intval($_GET['linearRatioLimit']) : 5;

$important = '!important';

$delaysVendors = array();
if ($transitionDelay) {
    array_push($delaysVendors, 'transition-delay');
    array_push($delaysVendors, '-webkit-transition-delay');    
}
if ($animationDelay) {
    array_push($delaysVendors, 'animation-delay');
    array_push($delaysVendors, '-webkit-animation-delay');    
}

$tab = ''; //'\t';

$baseClassName = '.dm';
$parent = $baseClassName . '_' . str_replace('.', '_', $delay);

//$nthMode = ':nth-child';
//$nthMode = ':nth-of-type';
$nthMode = (isset($_GET['nthMode'])) ? ':'.$_GET['nthMode'] : ':nth-child';

echo $parent . ' {' . PHP_EOL;
echo '}';
echo PHP_EOL;
echo PHP_EOL;

$newRatio = $linearRatio;
for ($i = 1; $i <= $range; $i++) {
    
    // .dm_0_2 .dm:nth-child(1)
    echo $tab;
    echo $parent . ' ' . $baseClassName . $nthMode . '(' . $i . ') {' . PHP_EOL;

    //  transition-delay: 0.0s !important;
    //  -webkit-transition-delay: 0.0s !important; /* Safari */ 
    //  animation-delay:0.0s;
    //  -webkit-animation-delay:0.0s; 

    if ($linearRatioLimit > $i) {
        $newRatio = $newRatio * 0.9; //$newRatio;
    }
    
    foreach ( $delaysVendors as $dly ) {
       echo $dly . ': ' . (($i - 1) * $delay * $newRatio) . 's ' . $important . ';' . PHP_EOL;
       // echo $dly . ': ' . (($i - 1) * $delay + ($i * $newRatio)) . 's ' . $important . ';' . PHP_EOL;
    }


    

    echo '}' . PHP_EOL;

}



?>