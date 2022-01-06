<?php
global $wpdb; 
$shops = $wpdb->get_results("SELECT * FROM wp_ms_shop");
$allPosts = $wpdb->get_results("SELECT * FROM wp_ms_products");
$allcount = count($allPosts);
$rowperpage = 20;
$products = $wpdb->get_results("SELECT * FROM wp_ms_products order by `time` desc limit 0, ".$rowperpage);
?>
<style type="text/css">
	/*#search_product{
		float: right;
	    position: absolute;
	    bottom: 0px;
	    right: 0px;
	}*/
	.d-none{
		display: none;
	}
	.products .theme-name{
		padding: 6px 10px !important;
		box-shadow: unset !important;
	}
</style>

<div class="wrap" style="position: relative;">
	<h1 class="wp-heading-inline">商品一覧</h1>	
	<a href="admin.php?page=ms-ordering-products-add" class="upload-view-toggle page-title-action" role="button" aria-expanded="false"><span class="upload">商品新規登録</span></a>
	<div style="float: right;display: flex;">
		<select id="shop" name="shop" style="margin-right: 0.5rem">
	        <option value="">代理店を選択</option>
	    <?php
	    foreach($shops as $shop){
	        ?>
	        <option value="<?php echo $shop->shop_name ?>"
	            <?php
	                if(isset($post) && ($post->shop == $shop->shop_name))
	                    echo 'selected';                                    
	            ?>
	            ><?php echo $shop->shop_name ?></option>
	        <?php
	    }
	    ?>
	    </select>
		<input placeholder="検索" type="search" aria-describedby="live-search-desc" id="search_product" class="wp-filter-search">
	</div>
</div>
<div class="wrap">
	<div class="theme-browser rendered">
		<div class="themes wp-clearfix">
        <?php
        // $products = $wpdb->get_results("SELECT * FROM wp_ms_products");
        $idx = 0;
        foreach($products as $product){
        	$idx++; 
        ?>
			<div class="theme active products" data-slug="product" id="product-<?php echo $idx ?>">
				<div class="theme-screenshot show_details" data-idx="<?php echo $idx ?>">
					<img src="../wp-content/plugins/membership-ordering-system/assets/product/<?=$product->img?>" alt="" id="product-img">
				</div>
				<button type="button" aria-label="View Theme Details for Avril" data-idx="<?php echo $idx ?>" class="more-details" id="avril-action">代理店詳細</button>
				<div class="theme-author">
					By Nayra Themes	
				</div>
				<div class="theme-id-container">					
					<h2 class="theme-name" id="name"><?=$product->name?></h2>
					<h2 class="theme-name" id="price">
						<?php
							if($product->sale != 0){
						?>
							<del aria-hidden="true"><?=number_format($product->regular)?><?=$product->currency?></del>
						<?php
							}else{
						?>
							<span><?=number_format($product->regular)?><?=$product->currency?></span>
						<?php
							}
						?>
						&nbsp;&nbsp;
						<?php
							if($product->sale != 0){
						?>
							<span><?=number_format($product->sale)?><?=$product->currency?></span>
						<?php
							}
						?>
					</h2>
					<span id="shop" style="display: none;"><?=$product->shop?></span>
					<span id="regular" style="display: none;"><?=$product->regular?></span>
					<span id="sale" style="display: none;"><?=$product->sale?></span>
					<span id="currency" style="display: none;"><?=$product->currency?></span>
					<span id="comment" style="display: none;"><?=$product->comment?></span>
					<div class="theme-actions">
						<a aria-label="Customize Avril" class="button button-primary customize load-customize hide-if-no-customize" href="admin.php?page=ms-ordering-products-add&i=<?php echo $product->id ?>">編集</a>
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
						<img src="http://10.10.10.183/wordpress/wp-content/themes/avril/screenshot.jpg" alt="" id="info-product-img">
					</div>			
				</div>
				<div class="theme-info">		
					<input type="hidden" id="show_data_idx" name="show_data_idx" />
					<h3 class="theme-author" style="font-size: 20px">商品名 : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-name" style="overflow-wrap: break-word;">jhkjhkj</span>			
					</p>							
					<h3 class="theme-author" style="font-size: 20px">取扱代理店 : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-shop" style="overflow-wrap: break-word;">jhkjhkj</span>			
					</p>							
					<h3 class="theme-author" style="font-size: 20px">通常価格 : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-regular" style="overflow-wrap: break-word;">jhkjhkj</span>			
					</p>				
					<h3 class="theme-author" style="font-size: 20px">セール価格 : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-sale" style="overflow-wrap: break-word;">jhkjhkj</span>			
					</p>					
					<!-- <h3 class="theme-author" style="font-size: 20px">セール価格 : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-currency">jhkjhkj</span>			
					</p>	 -->						
					<h3 class="theme-author" style="font-size: 20px">description : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-comment" style="overflow-wrap: break-word;">jhkjhkj</span>			
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
    				var search = jQuery("#search_product").val();
					var shop = jQuery("#shop").val();
    				jQuery.ajax({
						url: "../wp-content/plugins/membership-ordering-system/ajax-shop.php",
						type: "post",
						data: {
							row:row,
							search:search,
							shop:shop,
							page:'product'
						},
						/* remind that 'data' is the response of the AjaxController */
						success: function (data) {
							if(data == 'no')
								return;
							if(data.length < 1)
								return;
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
		jQuery("body").on("keydown", "#search_product", function(e) {
			searchText = jQuery(this).val();
		});
		jQuery("body").on("keyup", "#search_product", function(e) {
			var search = jQuery(this).val();
			var shop = jQuery("#shop").val();
			if(searchText == search)
				return;
			jQuery.ajax({
				url: "../wp-content/plugins/membership-ordering-system/ajax-shop.php",
				type: "post",
				data: {
					search:search,
					shop:shop,
					ajax:'ajax',
					to:'product'
				},
				/* remind that 'data' is the response of the AjaxController */
				success: function (data) {
					if(data == 'no')
						return;
					if(data.length < 1)
						return;
					displayResult(JSON.parse(data));
					jQuery('#row').val(0);
					reSetTotal();
				},
				error: function (data, textStatus, errorThrown) {
					console.log(data);
				},
			});
		});

		jQuery("body").on("change", "#shop", function(e) {
			var search = jQuery("#search_product").val();
			var shop = jQuery("#shop").val();
			jQuery.ajax({
				url: "../wp-content/plugins/membership-ordering-system/ajax-shop.php",
				type: "post",
				data: {
					search:search,
					shop:shop,
					ajax:'ajax',
					to:'product'
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
			showData('product-'+idx);
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
			showData('product-'+idx);
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
		var name = jQuery('#'+id+' #name').html();
		jQuery('#info-name').html(name);
		var shop = jQuery('#'+id+' #shop').html();
		jQuery('#info-shop').html(shop);
		var img = jQuery('#'+id+' #product-img').attr('src');
		jQuery('#info-product-img').attr('src', img);
		var regular = jQuery('#'+id+' #regular').html();
		jQuery('#info-regular').html(regular+' 円');
		var sale = jQuery('#'+id+' #sale').html();
		jQuery('#info-sale').html(sale==0 ? '' : sale+' 円');
		var comment = jQuery('#'+id+' #comment').html();
		jQuery('#info-comment').html(comment);

		jQuery('#show_data_idx').val(id);
	}

	function displayResult(data){
		jQuery('.themes').html('');	
		for(var i=0;i<data.length;i++){	
			// console.log(data);
			var result=  '';
			result += '<div class="theme active products" data-slug="product" id="product-'+(i+1)+'">';
			result += '<div class="theme-screenshot show_details" data-idx="'+(i+1)+'">';
			result += '<img src="../wp-content/plugins/membership-ordering-system/assets/product/'+data[i].img+'" alt="" id="product-img"></div>';
			result += '<button type="button" aria-label="View Theme Details for Avril" data-idx="'+(i+1)+'" class="more-details" id="avril-action">代理店詳細</button>';
			result += '<div class="theme-author">By Nayra Themes</div>';
			result += '<div class="theme-id-container"><h2 class="theme-name" id="name">'+data[i].name+'</h2>';
			result += '<h2 class="theme-name" id="price">';
			if(data[i].sale != 0){
				result += '<del aria-hidden="true">'+Number(data[i].regular).toLocaleString()+data[i].currency+'</del>';
				result += '&nbsp;&nbsp;<span>'+Number(data[i].sale).toLocaleString()+data[i].currency+'</span>';
			}else{
				result += '<span>'+Number(data[i].regular).toLocaleString()+data[i].currency+'</span>';
			}				
			result += '</h2>';
			result += '<span id="regular" style="display: none;">'+data[i].regular+'</span>';
			result += '<span id="sale" style="display: none;">'+data[i].sale+'</span>';
			result += '<span id="currency" style="display: none;">'+data[i].currency+'</span>';
			result += '<span id="comment" style="display: none;">'+data[i].comment+'</span>';
			result += '<div class="theme-actions">';
			result += '<a aria-label="Customize Avril" class="button button-primary customize load-customize hide-if-no-customize" href="admin.php?page=ms-ordering-products-add&i='+data[i].id+'">編集</a>';
			result += '</div></div></div>';
			jQuery('.themes').append(result);
			console.log(i);
		}
	}
	function displayResult1(data){
		var total = Number(jQuery('#totals').val());
		for(var i=0;i<data.length;i++){	
			// console.log(data);
			var result=  '';
			result += '<div class="theme active products" data-slug="product" id="product-'+(i+1+total)+'">';
			result += '<div class="theme-screenshot show_details" data-idx="'+(i+1+total)+'">';
			result += '<img src="../wp-content/plugins/membership-ordering-system/assets/product/'+data[i].img+'" alt="" id="product-img"></div>';
			result += '<button type="button" aria-label="View Theme Details for Avril" data-idx="'+(i+1)+'" class="more-details" id="avril-action">代理店詳細</button>';
			result += '<div class="theme-author">By Nayra Themes</div>';
			result += '<div class="theme-id-container"><h2 class="theme-name" id="name">'+data[i].name+'</h2>';
			result += '<h2 class="theme-name" id="price">';
			if(data[i].sale != 0){
				result += '<del aria-hidden="true">'+Number(data[i].regular).toLocaleString()+data[i].currency+'</del>';
				result += '&nbsp;&nbsp;<span>'+Number(data[i].sale).toLocaleString()+data[i].currency+'</span>';
			}else{
				result += '<span>'+Number(data[i].regular).toLocaleString()+data[i].currency+'</span>';
			}				
			result += '</h2>';
			result += '<span id="regular" style="display: none;">'+data[i].regular+'</span>';
			result += '<span id="sale" style="display: none;">'+data[i].sale+'</span>';
			result += '<span id="currency" style="display: none;">'+data[i].currency+'</span>';
			result += '<span id="comment" style="display: none;">'+data[i].comment+'</span>';
			result += '<div class="theme-actions">';
			result += '<a aria-label="Customize Avril" class="button button-primary customize load-customize hide-if-no-customize" href="admin.php?page=ms-ordering-products-add&i='+data[i].id+'">編集</a>';
			result += '</div></div></div>';
			jQuery('.themes').append(result);
			// console.log(i);
		}
	}
	function reSetTotal(){
		var total = jQuery(".products").length;
		jQuery('#totals').val(total);
	}
</script>