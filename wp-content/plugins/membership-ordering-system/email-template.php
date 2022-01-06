<?php 
	$html = "";
	$html .= "<p><h2>".$client->name."様</h2></p>";
	$html .= "<p>いつもお世話になっております。</p>";
	$html .= "<p>この度は、弊社製品をご注文いただき誠にありがとうございます。</p>";
	$html .= "<p>納品書を添付いたしますのでご確認ください。</p>";
	$html .= "<p>何卒宜しくお願い申し上げます。</p>";
	$html .= "<hr>";
	$html .= "<p><h2>".$_shop->shop_name."</h2></p>";
	$html .= "<p>".$_shop->shop_pref.'&nbsp;&nbsp;'.$_shop->shop_city.'&nbsp;&nbsp;'.$_shop->shop_address."</p>";
	$html .= "<p>".$_shop->tel."（営業時間：平日9:00～17:00）</p>";
	$html .= "<p>E-Mail：".$_shop->mail."</p>";
	$html .= "<p><a href='".get_bloginfo('url')."/sample-page/?invoice=".$history_id."'>".get_bloginfo('url')."/sample-page/?invoice=".$history_id."</a></p>";
	return $html;
?>