<?php
/*
Plugin Name: Linkflora Affiliate
Plugin URI: http://www.linkflora.com/index.php?action=sprzedaz_prowizyjna&lang=en
Description: Linkflora affiliate program widget for WordPress.
Author: Linkflora
Version: 1.0
*/

function displayContent()
{
	global $options;
	
	$lfa_pid = $options['affiliate_id'];
	$lfa_item_count = $options['item_count'];
	$lfa_row_count = $options['row_count'];
	$lfa_country = $options['country'];
	
	$soap_cli = new SoapClient("http://www.linkflora.com/externalsales.wsdl");
	echo '<div align="center">';
	
	$content = '<STYLE type="text/css">
	.text
	{
	    FONT-SIZE: 11px;
	    line-height: 14px;
	    COLOR: #000000;
	    FONT-FAMILY: arial, helvetica, sans-serif;
	    font-weight: normal;
	}
	.grayNote
	{
	    FONT-SIZE: 10px;
	    COLOR: #707070;
	    FONT-FAMILY: arial, helvetica, sans-serif;
	    font-weight: bold;
	    line-height: 12px;
	}
	.greenTitle
	{
	    FONT-SIZE: 12px;
	    COLOR: #83c326;
	    FONT-FAMILY: arial,helvetica,sans-serif;
	    text-decoration: none;
	    font-weight: bold;
	    line-height: 15px;
	}
	.greenTitle:hover
	{
	    FONT-SIZE: 12px;
	    COLOR: #83c326;
	    FONT-FAMILY: arial,helvetica,sans-serif;
	    text-decoration: underline;
	    font-weight: bold;
	    line-height: 15px;
	}
	.Link
	{
	  FONT-SIZE: 11px;
	  FONT-FAMILY: arial,helvetica,sans-serif;
	  text-decoration: underline;font-weight: bold;COLOR: #83c326;
	  line-height: 11px;
	}
	
	.Link:hover
	{
	  FONT-SIZE: 11px;
	  FONT-FAMILY: arial,helvetica,sans-serif;
	  text-decoration:none;font-weight: bold;color:#921a7a;
	  line-height: 11px;
	}
	</style>';
	
	switch($lfa_row_count)
	{
		case "1":
			if($lfa_item_count == "1")
				$content .= $soap_cli->getSingleProduct("en",$lfa_pid,$lfa_country);
			else
				$content .= $soap_cli->getHorizontalProducts("en",$lfa_pid,$lfa_item_count,$lfa_country);
		break;	
		default:
			if(($lfa_row_count > 1) && ($lfa_item_count == "1"))
				$content .= $soap_cli->getVerticalProducts("en",$lfa_pid,$lfa_row_count,$lfa_country);
			else
			$content .= $soap_cli->getFirstPageProductsExternSales("en",$lfa_row_count,$lfa_pid,$lfa_country);
	}
	echo $content;
	echo '</div>';
}

function widget_myLinkflora($args) {
	global $options;
	
	extract($args);
	
	$options = get_option("widget_myLinkflora");
	if(!is_array( $options ))
	{	
		$options = array(
      	'title' => 'Order flowers',
		'affiliate_id' => 562,
		'item_count' => 1,
		'row_count' => 2,
		'country' => 'Polska'
		);
  	}      
		
	echo $before_widget;
	echo $before_title;
	echo $options['title'];
	echo $after_title;
	displayContent();
	echo $after_widget;
}

function myLinkflora_control()
{
	global $options;

	$soap_cli = new SoapClient("http://www.linkflora.com/externalsales.wsdl");
	$options = get_option("widget_myLinkflora");
	
	if(!is_array( $options ))
	{
		$options = array(
      	'title' => 'Order flowers',
		'affiliate_id' => 562,
		'item_count' => 1,
		'row_count' => 2,
		'country' => 'Polska'
		);    	
	}    

	if($_POST['myLinkflora-Submit'])
	{
		$options['title'] = htmlspecialchars($_POST['myLinkflora-WidgetTitle']);
		$options['affiliate_id'] = htmlspecialchars($_POST['myLinkflora-AffiliateID']);
		$options['item_count'] = htmlspecialchars($_POST['myLinkflora-ItemCount']);
		$options['row_count'] = htmlspecialchars($_POST['myLinkflora-RowCount']);
		$options['country'] = htmlspecialchars($_POST['myLinkflora-Country']);
				
		update_option("widget_myLinkflora", $options);
	}

?>
  <p>
    <label for="myLinkflora-WidgetTitle">Widget Title: </label><br>
    <input type="text" id="myLinkflora-WidgetTitle" name="myLinkflora-WidgetTitle" value="<?php echo $options['title'];?>" style="width:100%;" /><br>
    <label for="myLinkflora-AffiliateID">Affiliate ID: </label><br>
    <input type="text" id="myLinkflora-AffiliateID" name="myLinkflora-AffiliateID" value="<?php echo $options['affiliate_id'];?>" style="width:100%;" /><br>
    <label for="myLinkflora-ItemCount">Column count: </label><br>
    <input type="text" id="myLinkflora-ItemCount" name="myLinkflora-ItemCount" value="<?php echo $options['item_count'];?>" style="width:100%;" /><br>
    <label for="myLinkflora-RowCount">Row count: </label><br>
    <input type="text" id="myLinkflora-RowCount" name="myLinkflora-RowCount" value="<?php echo $options['row_count'];?>"  style="width:100%;"/><br>
    <label for="myLinkflora-Country">Flower delivery country: </label><br>
	<select id="myLinkflora-Country" name="myLinkflora-Country" style="width:100%;">
	<option value="<?php echo $options['country'];?>"><?php echo $soap_cli->getLanguageString("en",$options['country']);?></option>
	<option value="Algeria">Algeria</option>
	<option value="Angola">Angola</option>
	<option value="Antigua">Antigua</option>
	<option value="Agrentyna">Argentina</option>
	<option value="Armenia">Armenia</option>
	<option value="Aruba">Aruba</option>
	<option value="Australia">Australia</option>
	<option value="Austria">Austria</option>
	<option value="Azerbejdzan">Azerbaijan</option>
	<option value="Azory">Azores</option>
	<option value="WyspyBahama">Bahama Islands</option>
	<option value="Bahrain">Bahrain</option>
	<option value="Barbados">Barbados</option>
	<option value="Bialorus">Belarus</option>
	<option value="Belgia">Belgium</option>
	<option value="Belize">Belize</option>
	<option value="Benin">Benin</option>
	<option value="Bermudy">Bermuda</option>
	<option value="Boliwia">Bolivia</option>
	<option value="BosniaHercegowina">Bosnia Herzegovina</option>
	<option value="Botswana">Botswana</option>
	<option value="Brazylia">Brazil</option>
	<option value="Brunei">Brunei</option>
	<option value="Bulgaria">Bulgaria</option>
	<option value="Kambodza">Cambodia</option>
	<option value="Kanada">Canada</option>
	<option value="Kajmany">Cayman Islands</option>
	<option value="ChannelIslands">Channel Islands</option>
	<option value="Chile">Chile</option>
	<option value="Chiny">China</option>
	<option value="Kolumbia">Colombia</option>
	<option value="WyspyCooka">Cook Islands</option>
	<option value="Kostaryka">Costa Rica</option>
	<option value="Chorwacja">Croatia</option>
	<option value="Curacao">Curacao</option>
	<option value="Cypr">Cyprus</option>
	<option value="Czechy">Czech Republic</option>
	<option value="Dania">Denmark</option>
	<option value="Dominikana">Dominican Republic</option>
	<option value="Ekwador">Ecuador</option>
	<option value="Egipt">Egypt</option>
	<option value="Salwador">El Salvador</option>
	<option value="Eritrea">Eritrea</option>
	<option value="Estonia">Estonia</option>
	<option value="Etiopia">Ethiopia</option>
	<option value="Fidzi">Fiji Islands</option>
	<option value="Finlandia">Finland</option>
	<option value="Francja">France</option>
	<option value="Gujana Francuska">French Guiana</option>
	<option value="Polinezja Francuska">French Polynesia</option>
	<option value="Gabon">Gabon</option>
	<option value="Gruzja">Georgia</option>
	<option value="Niemcy">Germany</option>
	<option value="Gibraltar">Gibraltar</option>
	<option value="Grecja">Greece</option>
	<option value="Gwadelupa">Guadeloupe</option>
	<option value="Guam">Guam , M.I.</option>
	<option value="Gwatemala">Guatemala</option>
	<option value="Gujana">Guyana</option>
	<option value="Haiti">Haiti</option>
	<option value="Honduras">Honduras</option>
	<option value="HongKong">Hong Kong</option>
	<option value="Wegry">Hungary</option>
	<option value="Islandia">Iceland</option>
	<option value="Indie">India</option>
	<option value="Indonezja">Indonesia</option>
	<option value="Irlandia">Ireland</option>
	<option value="Izrael">Israel</option>
	<option value="Wlochy">Italy</option>
	<option value="WybrzezeKosciSloniowej">Ivory Coast</option>
	<option value="Jamajka">Jamaica</option>
	<option value="Japonia">Japan</option>
	<option value="Jordania">Jordan</option>
	<option value="Kazachstan">Kazakhstan</option>
	<option value="Kenia">Kenya</option>
	<option value="Korea">Korea</option>
	<option value="Kuwejt">Kuwait</option>
	<option value="Kirgistan">Kyrgyzstan</option>
	<option value="Lotwa">Latvia</option>
	<option value="Liban">Lebanon</option>
	<option value="Lichtenstein">Liechtenstein</option>
	<option value="Litwa">Lithuania</option>
	<option value="Luxemburg">Luxemburg</option>
	<option value="Macedonia">Macedonia</option>
	<option value="Madera">Madeira</option>
	<option value="Malawi">Malawi</option>
	<option value="Malezja">Malaysia</option>
	<option value="Malta">Malta</option>
	<option value="Martynika">Martinique</option>
	<option value="Mauritius">Mauritius</option>
	<option value="Meksyk">Mexico</option>
	<option value="Monako">Monaco</option>
	<option value="Montenegro">Montenegro</option>
	<option value="Maroko">Morocco</option>
	<option value="Mozambik">Mozambique</option>
	<option value="Namibia">Namibia</option>
	<option value="Niderlandy">Netherlands</option>
	<option value="NowaKaledonia">New Caledonia</option>
	<option value="NowaZelandia">New Zealand</option>
	<option value="Nikaragua">Nicaragua</option>
	<option value="CyprPolnocny">Northern Cyprus</option>
	<option value="Norwegia">Norway</option>
	<option value="Oman">Oman</option>
	<option value="Pakistan">Pakistan</option>
	<option value="Panama">Panama</option>
	<option value="Paragwaj">Paraguay</option>
	<option value="Peru">Peru</option>
	<option value="Filipiny">Philippines</option>
	<option value="Polska">Poland</option>
	<option value="Portugalia">Portugal</option>
	<option value="Portoryko">Puerto Rico</option>
	<option value="Reunion">Reunion Island</option>
	<option value="Rumunia">Romania</option>
	<option value="Saint-Pierre-et-Miquelon">Saint Pierre Et Miquelon</option>
	<option value="ArabiaSaudyjska">Saudi Arabia</option>
	<option value="Serbia">Serbia</option>
	<option value="Seszele">Seychelles Islands</option>
	<option value="Singapur">Singapore</option>
	<option value="Slowacja">Slovakia</option>
	<option value="Slowenia">Slovenia</option>
	<option value="Afrykapoludniowa">South Africa</option>
	<option value="Hiszpania">Spain</option>
	<option value="Suriname">Suriname</option>
	<option value="Swaziland">Swaziland</option>
	<option value="Szwecja">Sweden</option>
	<option value="Szwajcaria">Switzerland</option>
	<option value="Tajwan">Taiwan</option>
	<option value="Tadżykistan">Tajikistan</option>
	<option value="Tailandia">Thailand</option>
	<option value="Tonga">Tonga</option>
	<option value="Tunezja">Tunisia</option>
	<option value="Turcja">Turkey</option>
	<option value="Turkmenistan">Turkmenistan</option>
	<option value="ZjednoczoneEmiratyArabskie">United Arab Emirates</option>
	<option value="WielkaBrytania">United Kingdom</option>
	<option value="USA">United States</option>
	<option value="Urugwaj">Uruguay</option>
	<option value="Uzbekistan">Uzbekistan</option>
	<option value="Wenezuela">Venezuela</option>
	<option value="Wietnam">Vietnam</option>
	<option value="WyspyDziewicze">Virgin Islands</option>
	<option value="IndieZachodnie">West Indies</option>
	<option value="Jugoslawia">Yugoslavia</option>
	<option value="Zambia">Zambia</option>
	<option value="Zimbabwe">Zimbabwe</option>
	</select>
    <input type="hidden" id="myLinkflora-Submit" name="myLinkflora-Submit" value="1" />
  </p>
<?php
}

function myLinkflora_init()
{
  register_sidebar_widget(__('Linkflora Affiliate'), 'widget_myLinkflora');
  register_widget_control(   'Linkflora Affiliate', 'myLinkflora_control', 300, 300 );    
}
add_action("plugins_loaded", "myLinkflora_init");
?>