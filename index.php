
<?php 
/* ############################# DATA CREATION SECTION ######################### */
// build class that contain airport variables
class Airport {
  public $id;
  public $name;
  public $code;
  public $lat;
  public $lng;
  //declare contruct method to create a new object
  public function __construct(
    $id,
    $name,
    $code,
    $lat,
    $lng
  ) {
    $this->id= $id;
    $this->name=$name;
    $this->code=$code;
    $this->lat=$lat;
    $this->lng=$lng;
  }
}

// build class that contain flight variables
class Flight {
  public $code_departure;
  public $code_arrival;
  public $price;
  public function __construct(
    $code_departure,
    $code_arrival,
    $price
  ) {
    $this->code_departure=$code_departure;
    $this->code_arrival=$code_arrival;
    $this->price=$price;
  }
  
}

//this array contain all airports
$airportArray=[];
//create airport object and push that in array
$firenzeAirport = new Airport (
  '1',
  'Aeroporto Amerigo Vespucci (FI)',
  'LIRQ',
  43.79348039655883, 
  11.208527232937147
);
$lameziaAirport = new Airport (
  '2',
  'Aeroporto Internazionale di Lamezia Terme (CZ)',
  'SUF',
  38.90949001258013, 
  16.24650387250154
);
//airports are pushed into array
array_push($airportArray, $firenzeAirport, $lameziaAirport);

//this array contain all flight
$flightsArray=[];
//create random flight object and push that in array
for($i=0; $i<=6; $i++){
  $flightObj = new Flight (
    'SUF ' . rand(100, 600),
    'LIRQ '. rand(100, 600),
    rand(20, 899)
  );
  array_push($flightsArray, $flightObj);
}

/* ##################################### LOGIC SECTION ############################################# */


//this array contain all flight s prices
$prices=[];
//this cycle filter and push flight price 
foreach($flightsArray as $flightPrice) {
 array_push($prices, $flightPrice->price);
}

//get length of array
$arrSize=count($prices);
//this snippet reorder array with crescent value just like sort($prices) funciton
for($i=0; $i < $arrSize; $i++ ) {
  for($k= $i+1; $k<$arrSize; $k++) {
    if($prices[$i]>$prices[$k]){
      $firstLoopIndex=$prices[$i];
      $prices[$i]=$prices[$k];
      $prices[$k]=$firstLoopIndex;
    }
  }
}
//get first value of reorder priced array, this row combined with snippet at row88 give the same result of min($prices) funciton
$minPrice=$prices[0];
//this array contain only the object with lowest price
$flightLow = array_filter(
  $flightsArray,
  function ($flight) use (&$minPrice) {
      return $flight->price == $minPrice;
  }
);

//extract airport code departure/arrival from flight with lowest price
$codeDeparture;
$codeArrival;
foreach($flightLow as $item) {
  $codeDeparture = $item->code_departure;
  $codeArrival=$item->code_arrival;
}
//extract airport name if code of airport is include in flight code
$depAirpName;
$arrAirpName;
foreach($airportArray as $element) {
  if($codeDeparture == strpos($codeDeparture, $element->code)){
    $depAirpName=$element->name;
  } else {
    $arrAirpName=$element->name;
  }
}

?>


<!-- ############################## PRINT SECTION ########################### -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOWEST PRICE third way</title>
  </head>
  <body>
    <p>refresh to change the result</p>
    <p>Third solution with For loops</p>
    <div class="wrapper" style="padding-left: 30px;">
      <!-- all flights section -->
      <div>
        All Flights
      </div>
      <ol class="all-flight">
        <?php
          foreach($flightsArray as $singleFlight) {
        ?>
        <li style="margin-bottom: 10px;">
            <ul>
            <li>Departure code: <?php echo$singleFlight->code_departure ?></li>
            <li>Arrival code: <?php echo$singleFlight->code_arrival ?></li>
            <li>Price: <?php echo$singleFlight->price ?> &euro;</li>
            </ul>
        </li>
        
        <?php 
          }
        ?>
      
      </ol>

      <!-- flight with lowest price section -->
      <div>
        <strong>
          Flight With Lowest Price
        </strong>
      </div>  
      <ul class="flight-lowestPrice">
        <?php
        foreach($flightLow as $flight) {
        ?>
        <li>
          Departure From: <?php echo $depAirpName ?>
        </li>
        <li style="margin-bottom: 10px;">
          Departure code: <?php echo $flight->code_departure ?>
        </li>
        <li>
          Arrival At: <?php echo $arrAirpName ?>
        </li>
        <li style="margin-bottom: 10px;">
          Arrival code: <?php echo $flight->code_arrival ?>
        </li>
        <li>
          Flight price: <?php echo $flight->price?> &euro;
        </li>
        <?php
        }
        ?>
      </ul>
      </div>
  </body>
</html>