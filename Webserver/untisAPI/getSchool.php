<?php
if (!isset($_GET["locale"])) {
  $_GET["locale"] = "";
}
header('Content-Type: application/json');
$timestamp = time();
$searchString = $_GET["search"];
// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://mobile.webuntis.com/ms/schoolquery2');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"id\":\"wu_schulsuche-$timestamp\",\"method\":\"searchSchool\",\"params\":[{\"search\":\"$searchString\"}],\"jsonrpc\":\"2.0\"}");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Pragma: no-cache';
$headers[] = 'Origin: https://webuntis.com';
$headers[] = 'Accept-Encoding: gzip, deflate, br';
$headers[] = 'Accept-Language: de-DE,de;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36 OPR/58.0.3135.79';
$headers[] = 'Content-Type: application/json;charset=UTF-8';
$headers[] = 'Accept: application/json, text/plain, */*';
$headers[] = 'Cache-Control: no-cache';
$headers[] = 'Referer: https://webuntis.com/';
$headers[] = 'Connection: keep-alive';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
$json = json_decode($result, TRUE);


if ($_GET["search"] == "") {
  if ($_GET["locale"] == "de_DE" || $_GET["locale"] == "de_AT" || $_GET["locale"] == "de_CH" || $_GET["locale"] == "de_LI" || $_GET["locale"] == "de" || $_GET["locale"] == "de_LU") {

      print_r("Suche nach einer Schule");
      echo "\n";
      print_r("Gebe den Schulnamen oder die Adresse ein");
  }else {
      print_r("Search for a school");
      echo "\n";
      print_r("Enter the school name or address");
  }
  echo "\n";
  print_r("//" . $json["error"]["message"] . "/");
  die();
}

if (isset($json["result"]["size"])) {
  if ($json["result"]["size"] == 0 && !isset($json["result"]["schools"][0]["displayName"])) {
    if ($_GET["locale"] == "de_DE" || $_GET["locale"] == "de_AT" || $_GET["locale"] == "de_CH" || $_GET["locale"] == "de_LI" || $_GET["locale"] == "de" || $_GET["locale"] == "de_LU") {

        print_r("Fehler:");
        echo "\n";
        print_r("Keine Suchergebnisse.");
    }else {
        print_r("Error:");
        echo "\n";
        print_r("No search results.");
    }
    echo "\n";
    print_r("//-/");
    die();
  }
}


if(isset($json["error"])){
    if ($json["error"]["message"] == "too many results"){
      if ($_GET["locale"] == "de_DE" || $_GET["locale"] == "de_AT" || $_GET["locale"] == "de_CH" || $_GET["locale"] == "de_LI" || $_GET["locale"] == "de" || $_GET["locale"] == "de_LU") {

          print_r("Zu viele Ergebnisse");
          echo "\n";
          print_r("Bitte schränken Sie die Suche ein");
      }else {
          print_r("Too many results");
          echo "\n";
          print_r("Be more specific.");
      }
        echo "\n";
        print_r("//" . $json["error"]["message"] . "/");
    }else {
      if ($_GET["locale"] == "de_DE" || $_GET["locale"] == "de_AT" || $_GET["locale"] == "de_CH" || $_GET["locale"] == "de_LI" || $_GET["locale"] == "de" || $_GET["locale"] == "de_LU") {
        print_r("Fehler:");
      }else {
        print_r("Error:");
      }

      echo "\n";
      print_r($json["error"]["message"]);
      echo "\n";
      print_r("//-/");
    }

}else {
  $json = $json["result"]["schools"];
  foreach ($json as $value) {
    print_r($value["displayName"]);
    echo "\n";
    print_r($value["address"]);
    echo "\n";
    print_r($value["serverUrl"]);
    echo "\n";
  }
}






?>
