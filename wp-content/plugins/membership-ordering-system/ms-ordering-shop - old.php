
<?php
global $wpdb; 

$allPosts = $wpdb->get_results("SELECT * FROM wp_ms_shop");
$allcount = count($allPosts);
$rowperpage = 20;
$posts = $wpdb->get_results("SELECT * FROM wp_ms_shop order by `time` desc limit 0, ".$rowperpage);
?>
<style type="text/css">
	#search_shop{
		float: right;
	    position: absolute;
	    bottom: 0px;
	    right: 0px;
	}
	.d-none{
		display: none;
	}
	@media screen and (max-width: 481px) {
		#search_shop{
			position: unset !important;
		}
	}
</style>

<div class="wrap" style="position: relative;">
	<h1 class="wp-heading-inline">代理店一覧</h1>	
	<a href="admin.php?page=ms-ordering-shop-add" class="upload-view-toggle page-title-action" role="button" aria-expanded="false"><span class="upload">代理店新規登録</span></a>
	<input placeholder="検索" type="text" id="search_shop">
</div>
<div class="wrap">
	<div class="theme-browser rendered">
		<div class="themes wp-clearfix">
        <?php
        
        $idx = 0;
        foreach($posts as $post){
        	$idx++; 
        ?>
			<div class="theme active shop_item" data-slug="shop" id="shop-<?php echo $idx ?>">
				<div class="theme-screenshot show_details" data-idx="<?php echo $idx ?>">
					<img src="../wp-content/plugins/membership-ordering-system/assets/shop/<?=$post->img?>" alt="" id="shop-img">
				</div>
				<button type="button" aria-label="View Theme Details for Avril" data-idx="<?php echo $idx ?>" class="more-details" id="avril-action">代理店詳細</button>
				<div class="theme-author">
					By Nayra Themes	
				</div>
				<div class="theme-id-container">					
					<h2 class="theme-name" id="shop-name"><?=$post->shop_name?></h2>
					<span id="shop-address" style="display: none;"><?=$post->shop_address?></span>
					<span id="name" style="display: none;"><?=$post->name?></span>
					<span id="tel" style="display: none;"><?=$post->tel?></span>
					<span id="mail" style="display: none;"><?=$post->mail?></span>
					<span id="invoice_info" style="display: none;"><?=$post->invoice_info?></span>
					<div class="theme-actions">
						<a aria-label="Customize Avril" class="button button-primary customize load-customize hide-if-no-customize" href="admin.php?page=ms-ordering-shop-add&i=<?php echo $post->id ?>">編集</a>
					</div>
				</div>
			</div>
        <?php        	
    	}
    	?>
		</div>
    	<input type="hidden" name="totals" id="totals" value="<?php echo $idx ?>">
	</div>
</div>
<div class="theme-overlay d-none details-modal" tabindex="0" role="dialog" aria-label="Theme Details">
	<div class="theme-overlay active">
		<div class="theme-backdrop"></div>
		<div class="theme-wrap wp-clearfix" role="document">
			<div class="theme-header">
				<button class="left dashicons dashicons-no disabled" disabled=""><span class="screen-reader-text">Show previous theme</span></button>
				<button class="right dashicons dashicons-no"><span class="screen-reader-text">Show next theme</span></button>
				<button class="close dashicons dashicons-no"><span class="screen-reader-text">Close details dialog</span></button>
			</div>
			<div class="theme-about wp-clearfix">
				<div class="theme-screenshots">			
					<div class="screenshot">
						<img src="http://10.10.10.183/wordpress/wp-content/themes/avril/screenshot.jpg" alt="" id="info-shop-img">
					</div>			
				</div>
				<div class="theme-info">		
					<input type="hidden" id="show_data_idx" name="show_data_idx" />
					<h3 class="theme-author" style="font-size: 20px">代理店名 : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-shop-name" style="overflow-wrap: break-word;">jhkjhkj</span>			
					</p>							
					<h3 class="theme-author" style="font-size: 20px">住所 : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-shop-address" style="overflow-wrap: break-word;">jhkjhkj</span>			
					</p>				
					<h3 class="theme-author" style="font-size: 20px">御担当者名 : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-name" style="overflow-wrap: break-word;">jhkjhkj</span>			
					</p>							
					<h3 class="theme-author" style="font-size: 20px">電話番号 : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-tel" style="overflow-wrap: break-word;">jhkjhkj</span>			
					</p>							
					<h3 class="theme-author" style="font-size: 20px">E-mail : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-mail" style="overflow-wrap: break-word;">jhkjhkj</span>			
					</p>							
					<h3 class="theme-author" style="font-size: 20px">請求書、納品書発送先情報 : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-invoice-info" style="overflow-wrap: break-word;">jhkjhkj</span>			
					</p>							
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="row" value="0">
<input type="hidden" id="all" name="all" value="<?php echo $allcount ?>" />
<script type="text/javascript">
	var searchText="";
	jQuery(document).ready(function () {

		jQuery(window).scroll(function(){ 
			var position = jQuery(window).scrollTop();
			var bottom = jQuery(document).height() - jQuery(window).height();

			if( position == bottom ){
				var row = Number(jQuery('#row').val());
				var allcount = Number(jQuery('#all').val());
				var rowperpage = 20;
				row = row + rowperpage;
				if(row <= allcount){
    				jQuery('#row').val(row);
    				var search = jQuery("#search_shop").val();
    				jQuery.ajax({
						url: "../wp-content/plugins/membership-ordering-system/ajax-shop.php",
						type: "post",
						data: {
							row:row,
							search:search,
							page:'shop'
						},
						/* remind that 'data' is the response of the AjaxController */
						success: function (data) {
							if(data == 'no')
								return;
							if(data.length < 1)
								return;
							// console.log(data);
							displayResult1(JSON.parse(data));
							reSetTotal();
						},
						error: function (data, textStatus, errorThrown) {
							console.log(data);
						},
					});
    			}
			}
		});
		jQuery("body").on("keydown", "#search_shop", function(e) {
			searchText = jQuery(this).val();
		});
		jQuery("body").on("keyup", "#search_shop", function(e) {
			var search = jQuery(this).val();
			if(searchText == search)
				return;
			jQuery('#row').val(0);
			jQuery.ajax({
				url: "../wp-content/plugins/membership-ordering-system/ajax-shop.php",
				type: "post",
				data: {
					search:search,
					ajax:'ajax',
					to:'shop'
				},
				/* remind that 'data' is the response of the AjaxController */
				success: function (data) {
					if(data == 'no')
						return;
					if(data.length < 1)
						return;
					// console.log(data);
					displayResult(JSON.parse(data));
					jQuery('#row').val(0);
					reSetTotal();
				},
				error: function (data, textStatus, errorThrown) {
					console.log(data);
				},
			});
		});

		jQuery("body").on("click", ".more-details, .show_details", function(e) {
			var idx = jQuery(this).data('idx');			
			reSetIdx(idx);			
			var sel_id = jQuery(this).parent().attr('id');
			jQuery('#show_data_idx').val(sel_id);
			showData(sel_id);
			jQuery('.details-modal').toggleClass('d-none');			
		});
		jQuery("body").on("click", ".details-modal .close", function(e) {
			jQuery('.details-modal').addClass('d-none');
		});
		jQuery("body").on("click", ".details-modal .left", function(e) {
			var sel_id = jQuery('#show_data_idx').val();
			var sel_ida = sel_id.split('-');
			var idx = parseInt(sel_ida[1]);
			if(idx == 1)
				return;
			idx--;
			showData('shop-'+idx);
			reSetIdx(idx);
		});
		jQuery("body").on("click", ".details-modal .right", function(e) {
			var sel_id = jQuery('#show_data_idx').val();
			var sel_ida = sel_id.split('-');
			var idx = parseInt(sel_ida[1]);
			var totals = jQuery('#totals').val();
			if(idx == totals)
				return;
			idx++;
			showData('shop-'+idx);
			reSetIdx(idx);
		});
	});

	function reSetIdx(idx){
		var totals = jQuery('#totals').val();
		if(idx != 1){
			jQuery('.details-modal .left').prop('disabled', false);
			jQuery('.details-modal .left').removeClass('disabled');
		}else{
			jQuery('.details-modal .left').prop('disabled', true);
			jQuery('.details-modal .left').addClass('disabled');
		}
		if(idx == totals){
			jQuery('.details-modal .right').prop('disabled', true);
			jQuery('.details-modal .right').addClass('disabled');
		}else{
			jQuery('.details-modal .right').prop('disabled', false);
			jQuery('.details-modal .right').removeClass('disabled');
		}
	}

	function showData(id){
		var shop_name = jQuery('#'+id+' #shop-name').html();
		jQuery('#info-shop-name').html(shop_name);
		var img = jQuery('#'+id+' #shop-img').attr('src');
		jQuery('#info-shop-img').attr('src', img);
		var shop_address = jQuery('#'+id+' #shop-address').html();
		jQuery('#info-shop-address').html(shop_address);
		var name = jQuery('#'+id+' #name').html();
		jQuery('#info-name').html(name);
		var tel = jQuery('#'+id+' #tel').html();
		jQuery('#info-tel').html(tel);
		var mail = jQuery('#'+id+' #mail').html();
		jQuery('#info-mail').html(mail);
		var invoice_info = jQuery('#'+id+' #invoice_info').html();
		jQuery('#info-invoice-info').html(invoice_info);


		jQuery('#show_data_idx').val(id);
	}

	function displayResult(data){
		jQuery('.themes').html('');	
		for(var i=0;i<data.length;i++){	
			// console.log(data);
			var result=  '';
			result += '<div class="theme active shop_item" data-slug="shop" id="shop-'+(i+1)+'">';
			result += '<div class="theme-screenshot show_details" data-idx="'+(i+1)+'">';
			result += '<img src="../wp-content/plugins/membership-ordering-system/assets/shop/'+data[i].img+'" alt="" id="shop-img"></div>';
			result += '<button type="button" aria-label="View Theme Details for Avril" data-idx="'+(i+1)+'" class="more-details" id="avril-action">代理店詳細</button>';
			result += '<div class="theme-author">By Nayra Themes</div>';
			result += '<div class="theme-id-container"><h2 class="theme-name" id="shop-name">'+data[i].shop_name+'</h2>';
			result += '<span id="shop-address" style="display: none;">'+data[i].shop_address+'</span>';
			result += '<span id="name" style="display: none;">'+data[i].name+'</span>';
			result += '<span id="tel" style="display: none;">'+data[i].tel+'</span>';
			result += '<span id="mail" style="display: none;">'+data[i].mail+'</span>';
			result += '<span id="invoice_info" style="display: none;">'+data[i].invoice_info+'</span>';
			result += '<div class="theme-actions">';
			result += '<a aria-label="Customize Avril" class="button button-primary customize load-customize hide-if-no-customize" href="admin.php?page=ms-ordering-shop-add&i='+data[i].id+'">編集</a>';
			result += '</div></div></div>';
			jQuery('.themes').append(result);
			// console.log(i);
		}
	}
	function displayResult1(data){
		var total = Number(jQuery('#totals').val());
		for(var i=0;i<data.length;i++){
			var result=  '';
			result += '<div class="theme active shop_item" data-slug="shop" id="shop-'+(i+1+total)+'">';
			result += '<div class="theme-screenshot show_details" data-idx="'+(i+1+total)+'">';
			result += '<img src="../wp-content/plugins/membership-ordering-system/assets/shop/'+data[i].img+'" alt="" id="shop-img"></div>';
			result += '<button type="button" aria-label="View Theme Details for Avril" data-idx="'+(i+1)+'" class="more-details" id="avril-action">代理店詳細</button>';
			result += '<div class="theme-author">By Nayra Themes</div>';
			result += '<div class="theme-id-container"><h2 class="theme-name" id="shop-name">'+data[i].shop_name+'</h2>';
			result += '<span id="shop-address" style="display: none;">'+data[i].shop_address+'</span>';
			result += '<span id="name" style="display: none;">'+data[i].name+'</span>';
			result += '<span id="tel" style="display: none;">'+data[i].tel+'</span>';
			result += '<span id="mail" style="display: none;">'+data[i].mail+'</span>';
			result += '<span id="invoice_info" style="display: none;">'+data[i].invoice_info+'</span>';
			result += '<div class="theme-actions">';
			result += '<a aria-label="Customize Avril" class="button button-primary customize load-customize hide-if-no-customize" href="admin.php?page=ms-ordering-shop-add&i='+data[i].id+'">編集</a>';
			result += '</div></div></div>';
			jQuery('.themes').append(result);
			// console.log(i);
		}
	}
	function reSetTotal(){
		var total = jQuery(".shop_item").length;
		jQuery('#totals').val(total);
	}
</script>