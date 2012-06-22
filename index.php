<link rel="stylesheet" type="text/css" href="./tpl/style.css">

<?php
ini_set("soap.wsdl_cache_enabled", 0);
ini_set("max_execution_time", 360); 
if($config["debug"] == true){
//debug
// Report all PHP errors (see changelog)
error_reporting(E_ALL);

// Report all PHP errors
error_reporting(-1);
//gesendetes Array ausgeben.
pre_print_r($_POST);
}
/*      
                                +#W,
                                  W,       MÜNSMEDIA GbR                  MÜNSMEDIA GbR
                                  W:                                      c/o webvariants GbR
    WWW              *WWWWW@#W*   W:       Dr.-Hermann-Fleck-Allee 3      Breiter Weg 232a
    W+   ,WWWWW##W+  W@  W@ ,WW   W@       57299 Burbach                  39104 Magdeburg
    W@   W@, W@ ,WW  W@  WW  .W   WW       
    WW   W#  WW  +W  W@  *W   W.  @W       Tel. 02736 / 50 94 97 - 4      Tel. 0391 / 50 54 93 8 - 0
    +W  ,W@  @W   W  @W   W,      +W       Fax  02736 / 50 94 97 - 5      Fax  0391 / 50 54 93 8 - 8
     W   W@   W                  WWW
     W,                                    http://muensmedia.de
     WWW

   Copyright (C) 2012  MÜNSMEDIA GbR

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 
 */
/**
 * @copyright 2012 MÜNSMEDIA GbR
 * @author Core Author Munsmedia GbR
 * @version Core mm-delivery-note MÜNSMEDIA GbR
 * @version 07.06.2012 1.4.2 beta
 * @author BSE-Hosting Service Björn Romanski 
 */
$config = array();

function throwError($message, $strType='success')
{
if($strType == 'success')
    {echo "<div class='message ".$strType."'>".$message.'<br>';}else{
echo "<b>Es ist ein Fehler aufgetreten</b> <br>";
echo "<div class='message ".$strType."'>".$message.'<br>';
echo "</div>";
 exit; 
    }
}

function readContent($file, $full=false)
{
 if(!isset($result)){$result = "";}else{}
  if($full)
    {
    $handle = fopen ($file, "r");
    while (!feof($handle)) 
        $result .= utf8_encode(fgets($handle));
    fclose ($handle);
    unset($handle);
    return $result; 
 }
 else
 {
  $file = fopen($file, "r");
  $result = fgets($file);
  fclose($file);  
  unset($file);
  return $result; 
 }
}
$angebotsnummer_off ='';

require('conf/config.php');
$client = new soapclient($strApiWsdlUrl); 
if(empty($client->_soap_version))
{
 throwError("Bitte pr&uuml;fe deine API Daten");
}

if((int)$config["mailformat"] === 0 || (int)$config["mailformat"] === 2)
{
 if(!file_exists($config["path_emailhtml"]))
  throwError("Das Template f&uuml;r die HTML Emails ist nicht vorhanden","error");
  $email_html = readContent($config["path_emailhtml"], true);

 if(!file_exists('tpl/email_firma.html'))
  throwError("Das Template f&uuml;r die HTML Emails ist nicht vorhanden",'error');
  $email_firmahtml = readContent('tpl/email_firma.html', true);
}
if((int)$config["mailformat"] === 0 || (int)$config["mailformat"] === 1)
{
 if(!file_exists('tpl/email_firmatxtformat.txt'))
  throwError("Das Template f&uuml;r die Plaintext Emails ist nicht vorhanden",'error');
  $email_txt = readContent($config["path_emailtxt"], true);
   if(!file_exists($config["path_emailtxt"]))
  throwError("Das Template f&uuml;r die Plaintext Emails ist nicht vorhanden",'error');
  $email_firmatxt = readContent('tpl/email_firmatxtformat.txt', true);
}
$client = new soapclient($strApiWsdlUrl); 

$arrResult = $client->getOffer(API_KEY, $_GET['iid']);


$data = $arrResult['result'];
	
$path_to_gsales = str_replace('mm-offer-note/index.php', '', $_SERVER['SCRIPT_FILENAME']);

function pre_print_r($arr){
	echo '<pre>';
		print_r($arr);
	echo '</pre>';
}

if(count($_POST) == 0){
	require('tpl/out_html.php');
}
else{
	$i = 0;
	while(isset($data->pos[$i])){
		if(!isset($_POST['print_'.$data->pos[$i]->id]))
			unset($data->pos[$i]);
		$i++;
	}
		
	require('../lib/inc.cfg.php');
	$var_array = (array) $data;
	$var_array['base'] = (array) $var_array['base'];
	$var_array['pos'] = (array) $var_array['pos'];
	$var_array['summ'] = (array) $var_array['summ'];
	
	// Blanko oder Briefpapier
	if($_POST['dlvry-form'] == 'Blanko'){
		$booBlanko = true; 
		$docname = $prefix.($data->base->id + $offset).'_b.pdf';
	} else {
		$booBlanko = false;
		$docname = $prefix.($data->base->id + $offset).'.pdf';
	}
	
	// Get Config-Data out of the db
	mysql_connect($db[0]['host'],$db[0]['user'],$db[0]['password']);
	mysql_select_db($db[0]['database']);
	mysql_query("SET `names` 'utf8'");
	
	$result = mysql_query('SELECT * FROM `configuration`');
	while($row = mysql_fetch_object($result)){
	// type-conversion text -> boolean
		switch ($row->value){
			case "false": 
                            $cfg[$row->id] = false; 
                            break;
			case "true": 
                            $cfg[$row->id] = true; 
                            break;
			default: 
                            $cfg[$row->id] = $row->value;
		}
	}
	// Check wheter file already exists
	if (file_exists($path_to_gsales.$cfg['dir_data'].$cfg['dir_documents'].$docname)){
		if($_POST['dlvry-form'] == 'Blanko')
			$docname = $prefix.($data->base->id + $offset).'_'.time().'_b.pdf';
		else 
			$docname = $prefix.($data->base->id + $offset).'_'.time().'.pdf';
	}
	
	require('tpl/out_pdf/tpl.def_deliverynotice.php');
	
	// Save delivery date to bill
	if($addDeliveryDate){
		$date = explode('.', $_POST['date']);
		$arrResult = $client->updateOffer($strAPIKey, $_GET['iid'], array('deliverydate' => $date['2'].'-'.$date['1'].'-'.$date['0']));
	}
         if(isset($_POST['send_approval']) AND $_POST['send_approval'] == '1'){
        //1 = Automatische Freigabe 0 = Keine Freigabe
                $config["send_approval"]        = 0; 
         }else{
                $config["send_approval"]        = 1; 
         }


        if(isset($_POST['mailspool']) AND $_POST['mailspool'] == 'mailspool'){
   $arrVars = array("{Anrede_Email}",
                    "{Anrede_Email_Nachname}",
                    "{Anrede_Email_Vorname}",
                    "{Anrede_Email_Titel}",
                    "{Betrag_gesamt}",
                    "{Waehrung}",
                    "{Rechnungsnr}",
                    "{AngebotsnummerDatum}",
                    "{Kundennummer}",
                    "{Angebotsnummer-off}",
                    "{Angebotsnummer}"
       );
        $angebotsnummer_off = $data->base->id + $offset;
	$customerData = $client->getCustomer($strAPIKey, $data->base->customers_id);    
        $arrValues = array(utf8_encode($customerData["result"]->title)." ".utf8_encode($customerData["result"]->firstname)." ".utf8_encode($customerData["result"]->lastname), 
                       utf8_encode($customerData["result"]->lastname), 
                       utf8_encode($customerData["result"]->firstname), 
                       utf8_encode($customerData["result"]->title), 
                       number_format($data->base->rounded_amount, 2), 
                       utf8_encode($data->base->curr_symbol),
                       utf8_encode($data->base->invoiceno),
                        date("d.m.Y", strtotime($data->base->status_date)),
                       $customerData["result"]->customerno,
                       $angebotsnummer_off,
                       $data->base->id
					  ); 
     $dokumente = array("Angebotbestpdf" =>$path_to_gsales.$cfg['dir_data'].$cfg['dir_documents'].$docname);
     $spoolData = $client->createMailspoolEntry(API_KEY, 
             array(
                    "useDefaultFrom" => (bool)$config["useDefaultFrom"], 
                    "from_email" =>  utf8_encode($config["from_email"]),
                    "from_name" =>  utf8_encode($config["from_name"]),
                    "to_email" => $customerData["result"]->email,
                    "to_name" => utf8_encode($customerData["result"]->firstname).' '.utf8_encode($customerData["result"]->lastname),  
                    "subject" =>  utf8_encode($config["subject"]),
                    "body" => str_replace($arrVars, $arrValues, $email_html),
                    "body_plain" => str_replace($arrVars, $arrValues, $email_txt),
                    "send_approval" => $config["send_approval"],
                    "sendplan_actionid" => $config['sendplan_actionid1'],
                    "mailformat" => $config["mailformat"],
                    "attachements" => $dokumente
                         )); 
     $spoolData2 = $client->createMailspoolEntry(API_KEY, 
             array(
                    "useDefaultFrom" => (bool)$config["useDefaultFrom"], 
                    "from_email" =>  utf8_encode($config["from_email"]),
                    "from_name" =>  utf8_encode($config["from_name"]),
                    "to_email" => $config['FirmenAdresse'],
                    "to_name" => utf8_encode($config['firma']).' '.utf8_encode($config['buchhaltung']),  
                    "subject" =>  utf8_encode($config["subject"]),
                    "body" => str_replace($arrVars, $arrValues, $email_firmahtml),
                    "body_plain" => str_replace($arrVars, $arrValues, $email_firmatxt),
                    "send_approval" => $config["send_approval"],
                    "sendplan_actionid" => $config['sendplan_actionid2'],
                    "mailformat" => $config["mailformat"]
                    //array("Angebotbestpdf" =>$path_to_gsales.$cfg['dir_data'].$cfg['dir_documents'].$docname);
                         )); 
            throwError("Es wurden 2 E-Mails im Mailspool erstellt.","success");
	 unset($customerData, $spoolData, $spoolData2,$dokumente);
        }
        else
            {
            throwError("kein Mailspool eintrag vorgenommen.","success");
        }
        
        
	// Save Delivery Notice to User-Documents
	$query = "INSERT INTO `documents` SET 
                    `user_id` = '".$_COOKIE['UID']."', 
                    `username` = '".$_COOKIE['UNAME']."', 
                    `created` = '".date('Y-m-d H:i:s', time())."', 
                    `sub` = 'subcustomer', 
                    `recordid` = '".$data->base->customers_id."', 
                    `original_filename` = '".$docname."', 
                    `file` = '".$docname."', 
                    `title` = 'Angebots-Bestätigung ".$prefix.($data->base->id + $offset)."', 
                    `description` = '".$label." ".$prefix.($data->base->id + $offset)." vom ".$_POST['date']."', 
                    `public` = '".$public."'
                ";
	if(mysql_query($query)){
		echo($label." ".$prefix.($data->base->id + $offset)." vom ".$_POST['date']." wurde erfolgreich erstellt.<br /><br />Es wurden keine Fehler gefunden.
			Sie können diesen Dialog nun schließen.".
			'<script type="text/javascript">
				window.open(\'../index.php?p=file&loc='.$cfg['dir_documents'].$docname.'\');
			</script>');
	}
	else
            {
		throwError("Es ist ein Fehler bei der Erstellung der Angebotsbestätigung aufgetreten.",'error');
	}
}

?>
