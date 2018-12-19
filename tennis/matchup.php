<?

$servername = "localhost";
$username = "";
$password = "";
$dbname = "betting";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
}

$GameName;
$Player1;
$Player2;
$P1OddsCrown;
$P2OddsCrown;
$P1OddsSports;
$P2OddsSports;
$P1OddsLads;
$P2OddsLads;

$sqlSelectAll = "SELECT * FROM tennisLadBrokes";

$result = $conn->query($sqlSelectAll);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        //Reset everything

        $GameName = null;
        $Player1 = null;
        $Player2 = null;
        $P1OddsCrown = null;
        $P2OddsCrown = null;
        $P1OddsSports = null;
        $P2OddsSports = null;
        $P1OddsLads = null;
        $P2OddsLads = null;

        $GameName = $row["title"];
        $P1OddsLads = $row["player1Odds"];
        $P2OddsLads = $row["player2Odds"];

        echo "<h2>" . $GameName . "</h2>" . "<br>" . "Ladbrokes odds P1: " . $P1OddsLads . " Ladbrokes odds P2: " . $P2OddsLads . "<br>";
        //var_dump($row);
        //echo $row["title"];
        $title = explode(" ", $row["title"]);
        //echo $title;
        $titleA = mb_strimwidth($title[0], 0, 1);
        //echo $titleA;
        $titleB = mb_strimwidth($title[3], 0, 1);
        
        $titleV = mb_strimwidth($title[2], 0, 1);
        $sportsTitle = $titleA." ".$title[1]." ".$titleV." ".$titleB." ".$title[4];

        //echo $sportsTitle;

        //$sportBetPlayer1Name = $row["player1"]
        $startTime = $row["startTime"];
        $sportsStartTime = $startTime+300;
        //echo $startTime;
//startTime = '$startTime'
       $sqlSportsBet = "SELECT * FROM tennisSportsBet WHERE title = '$sportsTitle' AND startTime = '$sportsStartTime'";

       //$resultX = $conn->query($sqlSportsBet);
       $resultX = $conn->query($sqlSportsBet);
       
       if ($resultX->num_rows > 0) {
         
           // output data of each row
           while($rowX = $resultX->fetch_assoc()) {
             // var_dump($rowX);
              $P1OddsSports = $rowX["player1Odds"];
              $P2OddsSports = $rowX["player2Odds"];
              

               echo "SportsBet odds P1: " . $P1OddsSports . " SportsBet odds P2: " . $P2OddsSports . "<br>"; 
           }
       } else {
           //echo "\n\n  No sportsBet results";
       }

       $crownTitle = $title[0]." ".$title[1]." ".$titleV." ".$title[3]." ".$title[4];
       
       //need time there as well
       $sqlCrown = "SELECT * FROM tennisCrown WHERE title = '$crownTitle' AND startTime = '$startTime'";
       
              //$resultX = $conn->query($sqlSportsBet);
              $resultX = $conn->query($sqlCrown);
              
              if ($resultX->num_rows > 0) {
                
                  // output data of each row
                  while($rowX = $resultX->fetch_assoc()) {
                    // var_dump($rowX);
                     $P1OddsCrown = $rowX["player1Odds"];

                     $P2OddsCrown = $rowX["player2Odds"];
                     
                     echo "Crown Odds P1: " . $P1OddsCrown . " Crown odds P2: " . $P2OddsCrown . "<br><br>";  
                  }
              } else {
                  //echo "\n\n  No Crown results";
                  echo "<br><br>";
              }
              $p1Array = array($P1OddsLads, $P1OddsSports, $P1OddsCrown);
              $p2Array = array($P2OddsLads, $P2OddsSports, $P2OddsCrown);
          
              CalculateResults($crownTitle, $p1Array, $p2Array);
       
    }

   
    
    
} else {
    echo "No crown results";
}

function CalculateResults($title, $p1Arr, $p2Arr){
echo "Calculating<br>";

    foreach ($p1Arr as $value){
        foreach ($p2Arr as $valu2){
            
           

            if (!empty($valu2) && !empty($value)){
                echo $value . " : " . $valu2;
                if ((1>(1/$value)+(1/$valu2)) == TRUE ){    
                    echo " True <br>";
                    $winnerString = $title . " " . $value . " " . $valu2;
                    sendMail($winnerString); 
                } else {
                    echo " false <br>";
                }
            }
            
        }
    }      
    
    
}

function sendMail($resultWin){
    
    $url = 'https://api.sendgrid.com/';
    $user = 'mcinnes';
    $pass = '';
    
    $json_string = array(
    
      'to' => array(
        'mcinnes@me.com'
      ),
      'category' => 'test_category'
    );
    
    
    $params = array(
        'api_user'  => $user,
        'api_key'   => $pass,
        'x-smtpapi' => json_encode($json_string),
        'to'        => 'mcinnes@me.com',
        'subject'   => 'testing from curl',
        'html'      => $resultWin,
        'text'      => 'testing body',
        'from'      => 'example@sendgrid.com',
      );
    
    
    $request =  $url.'api/mail.send.json';
    
    // Generate curl request
    $session = curl_init($request);
    // Tell curl to use HTTP POST
    curl_setopt ($session, CURLOPT_POST, true);
    // Tell curl that this is the body of the POST
    curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
    // Tell curl not to return headers, but do return the response
    curl_setopt($session, CURLOPT_HEADER, false);
    // Tell PHP not to use SSLv3 (instead opting for TLS)
    curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    
    // obtain response
    $response = curl_exec($session);
    curl_close($session);
    
    // print everything out
    print_r($response);
    
    
}

?>