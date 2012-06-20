<?php
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

**/

/**
 * @copyright 2012 MÜNSMEDIA GbR
 * @author Core Author Munsmedia GbR
 * @version Core mm-delivery-note MÜNSMEDIA GbR
 * @version 05.06.2012 1.0 beta
 * @author BSE-Hosting Service Björn Romanski 
 */

$config = array();
// Enable and generate API key in your g*Sales Installation: left main navi -> "Administration" -> "API"
$strAPIKey = 'rdkcs0xEGzKbkHxiGohM';

// Replace with your g*sales installation URL 
$strApiWsdlUrl = 'http://localhost/gsales2/api/api.php?wsdl';

// Angebotsprefix
$prefix = 'angb';

// Lieferscheinoffset
$offset = 8000;

// Label AngebotsBestätigung-Nr.:
$label = 'AngBestätigung-Nr';

// Headline Angebot
$headline = "Angebots-Bestätigung";
//Pfad zum html Template
$config["path_emailhtml"]       = 'tpl/email_htmlformat.html';
//Pfad zum text Template
$config["path_emailtxt"]        = 'tpl/email_txtformat.txt'; 
//Absender
$config["from_email"]           = 'Angebot@domain.tld';
//Name des Absenders
$config["from_name"]            = 'Buchhaltung';
//Betreff/Subject
$config["subject"]              = $headline;
//Empfänger der Copy
$config['FirmenAdresse']        = "support@domain.tld"; 
//Name des Absenders
$config['buchhaltung']          = "Buchhaltung"; 
//Name der Firma
$config['firma']                = "BSE-Hosting Service"; 
//standart fallback
$config['sendplan_actionid1']   = "1"; 
//eigene Firmen Adresse
$config['sendplan_actionid2']   = "5"; 

/**
 * Mailformat
 * E-Mail Format
 * 0 = HTML & Plaintext
 * 1 = Plaintext
 * 2 = HTML
 */
$config["mailformat"]           = 0; 
//Sollen die Standardabsenderdaten verwendet werden?
$config["useDefaultFrom"]       = true;
// True Schaltet Fehlermeldungen ein. Für nuter eher unwichtig.
$config["debug"]                = false;
// Einleitungstext
$einleitungstext = "Folgendes Angebot wird Hiermit bestätigt:";

// Abschlusstext
$abschlusstext = "Bei Fragen und Problemen zu dieser Leistung melden Sie sich bitte.
Vielen Dank für Ihr Vertrauen und auf weiterhin gute Zusammenarbeit.";

// Lieferschein standardmäßig als blanko?
$blanko_by_default = false;

// Angebote im Kundenfrontend unter Dokumente anzeigen?
// 0 -> Nein
// 1 -> Ja
$public = 1;

// Angebotsdatum automtaisch zur Rechnung hinzufügen
$addDeliveryDate = false;