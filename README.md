g*Sales Delivery Notice
=========================
     
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

   Copyright (C) 2012  MüNSMEDIA GbR

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
 

  @copyright 2012 MÜNSMEDIA GbR
  @author Core Author Munsmedia GbR
  @version Core mm-offer-note
  @version 06.06.2012 1.4 beta
  @author BSE-Hosting Service Björn Romanski 
 


    Installation:
    
    1.) Copy this folder into your g*Sales-Installation Path, for example
        /var/www/gsales/ and rename the folder to "mm-offer-note"
        
    2.) Activate g*Sales API using the web-panel "Administration" -> "API"
    
    3.) Change to folder /mm-offer-note/conf/".
    
    4.) Rename file config.dist.php" to "config.php" and update settings.
    
    5.) Edit /gsales/lib/tpl/subinvoice/subShow.php an insert in line 175:

            {* INVOICE OPTIONS  - DELIVERY Offer NOTE *}
                        {if $type == 'offers'}
                        <td>
                            <img src="{$path}mm-offer-note/img/icon_copy.png" alt="copy" /><br />
                            <a href="{$path}mm-offer-note/index.php?p=show&iid={$idata.base.id}" onclick="$('#mm-delivery-note-dialog').html('<iframe style=\'width: 800px; height: 500px; overflow-x: hidden;\' frameborder=\'0\' src=\'{$path}mm-offer-note/index.php?p=show&iid={$idata.base.id}\'></iframe>'); $('#mm-delivery-note-dialog').dialog({ldelim}title: 'Angebot Bestätigen erstellen', height: 550, width: 835, modal: true{rdelim}); return false;">Angebot Bestätigen</a>
                            <div id="mm-delivery-note-dialog"></div>
                        </td>
                        {/if}


			
	6.) You are now able to create delivery notes. 
	    You will find the link & icon in invoice-detail view in g*Sales.
	    
	7.) Feel free to improve this plugin an commit improvements:
	    https://github.com/etlam/g-sales-delivery-note
	    
	8.) Enjoy it!	
	