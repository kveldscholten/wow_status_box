<style type="text/css" media="screen">
    #realmStastusBox {
        width: 88px;
        height: 95px;
        margin: 0 auto;
        color: #000;
    }

    #realmUp {
        width: 88px;
        height: 41px;
        background: url(include/images/realmstatus/up.png);
    }

    #realmUp2 {
        width: 88px;
        height: 54px;
        background: url(include/images/realmstatus/up2.png);  
    }

    #realmDown {
        width: 88px;
        height: 41px;     
        background: url(include/images/realmstatus/down.png);
    }

    #realmDown2 {
        width: 88px;
        height: 54px;   
        background: url(include/images/realmstatus/down2.png);  
    }

    @font-face { 
        font-family: 'Friz Quadrata TT';
        src: url(include/images/realmstatus/FRIZQT__.ttf) format('truetype');
    }

    #realmStatusName {
        width: 88px;
        height: 24px;
        text-align: center;
        display: table-cell;
        vertical-align: middle;
        padding: 2px 4px 2px 4px;
        font-size: 10px;
        font-family: Friz Quadrata TT;
        float: both;
    }

    #realmStatusArt {
        width: 88px;
        height: 17px;
        text-align: center;
        display: table-cell;
        vertical-align: middle;
        padding: 2px 4px 7px 4px;
        font-size: 10px;
        font-family: Friz Quadrata TT;
        font-weight: bold;
    }
</style>

<?php

defined('main') or die('no direct access');

$sRealmName = db_result(db_query("SELECT wert FROM `prefix_config` WHERE schl='realmname'"), 0);
$sRegion = db_result(db_query("SELECT wert FROM `prefix_config` WHERE schl='serverregion'"), 0);
$sAPIURL = 'http://' . $sRegion . '.battle.net/api/wow/';
$sRawEncodedRealm = rawurlencode($sRealmName);

$aClassStatus = array(
    '0' => 'realmDown',
    '1' => 'realmUp'
);
$aClassStatus2 = array(
    '0' => 'realmDown2',
    '1' => 'realmUp2'
);
$aClassType = array(
    'pve' => '- PvE -',
    'pvp' => '- PvP -',
    'rp' => '- RP -',
    'rppvp' => '- RP/PvP -',
);

$sRequestURL = $sAPIURL . 'realm/status?realm=' . $sRawEncodedRealm;
$sResponse = @file_get_contents($sRequestURL, true);

$aRealmData = json_decode($sResponse, true);

echo '
<div id="realmStastusBox">
    <div id="' . $aClassStatus[$aRealmData['realms'][0]['status']] . '"></div>
    <div id="' . $aClassStatus2[$aRealmData['realms'][0]['status']] . '">
        <div id="realmStatusName">' . $aRealmData['realms'][0]['name'] . '</div>
        <div style="clear:left;"></div>
        <div id="realmStatusArt">' . $aClassType[$aRealmData['realms'][0]['type']] . '</div>
    </div>
</div>
';

?>