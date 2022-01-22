<link href="<?php echo plugin_dir_url( __FILE__) ?>/assets/css/sb-admin-2.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo plugin_dir_url( __FILE__) ?>/assets/css/agency.css" rel="stylesheet">
<?php
global $wpdb; 
if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'ajax'){
	if(!isset($_REQUEST['search']) || empty($_REQUEST['search']) || $_REQUEST['search'] == ''){
		echo 'no';
		exit;
	}
	$posts = $wpdb->get_results("SELECT * FROM wp_ms_shop where shop_name like '%".$_REQUEST['search']."%'");
	echo json_encode($posts);
	exit;
}
$shops = $wpdb->get_results("SELECT * FROM wp_ms_shop");
$allPosts = $wpdb->get_results("SELECT * FROM wp_ms_client");
$allcount = count($allPosts);
$rowperpage = 20;
$posts = $wpdb->get_results("SELECT * FROM wp_ms_client order by `time` desc limit 0, ".$rowperpage);
?>
<style type="text/css">
	/*.wp-filter-search{
		float: right;
	    position: absolute;
	    bottom: 0px;
	    right: 0px;
	}*/
	.d-none{
		display: none;
	}
</style>
<div class="wrap" style="position: relative;">
	<h1 class="wp-heading-inline">客先一覧</h1>	
	<a href="admin.php?page=ms-ordering-client-add" class="upload-view-toggle page-title-action" role="button" aria-expanded="false"><span class="upload">客先新規登録</span></a>
	<div style="float: right;display: flex;margin-top: 9px">
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
		<input placeholder="検索" type="search" aria-describedby="live-search-desc" id="search_shop" class="wp-filter-search">
	</div>
</div>
<div class="wrap">
	<div class="row">
        <div class="result_m_list col-12 row pt-2">    
			<?php
	        
	        $idx = 0;
	        foreach($posts as $post){
	        	$idx++; 
		        ?>
	            <div class="result_m_item col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 mb-1 p-2" data-id="<?=$post->id?>">
	                <div class="agency_item">
	                    <div class="mb-2 item_img_div">
	                        <img src="<?php echo plugin_dir_url( __FILE__) ?>/assets/client/<?=$post->img?>">
	                        <!-- <button type="button" aria-label="View Theme Details for Avril" data-idx="<?php echo $idx ?>" class="more-details" id="avril-action">代理店詳細</button> -->
	                    </div>
	                    <div class="col-12 item p-2">
	                        <div class="item-content">
	                            サロン名 : <?=$post->name?>
	                        </div>
	                        <div class="item-content">
	                            取扱代理店 : <?=$post->shop?>
	                        </div>
	                        <div class="item-content">
	                            住所 : <?=$post->address?>
	                        </div>
	                        <div class="item-content">
	                            電話番号 : <?=$post->tel?>
	                        </div>
	                        <div class="item-content">
	                            E-mail : <?=$post->mail?>
	                        </div>
	                        <div class="item-content">
	                            配送先住所 : <?=$post->shipping_info?>
	                        </div>
	                    </div>
	                </div>
		            <!-- <span id="name" style="display: none;"><?=$post->name?></span>
		            <span id="shop" style="display: none;"><?=$post->shop?></span>
					<span id="address" style="display: none;"><?=$post->address?></span>
					<span id="tel" style="display: none;"><?=$post->tel?></span>
					<span id="mail" style="display: none;"><?=$post->mail?></span>
					<span id="shipping_info" style="display: none;"><?=$post->shipping_info?></span> -->
	            </div>
	            <?php
        	}
            ?>
        </div>
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
					<h3 class="theme-author" style="font-size: 20px">サロン名 : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-shop-name">jhkjhkj</span>			
					</p>							
					<h3 class="theme-author" style="font-size: 20px">取扱代理店 : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-shop-address">jhkjhkj</span>			
					</p>				
					<h3 class="theme-author" style="font-size: 20px">住所 : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-name">jhkjhkj</span>			
					</p>							
					<h3 class="theme-author" style="font-size: 20px">電話番号 : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-tel">jhkjhkj</span>			
					</p>							
					<h3 class="theme-author" style="font-size: 20px">E-mail : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-mail">jhkjhkj</span>			
					</p>							
					<h3 class="theme-author" style="font-size: 20px">配送先住所 : </h3>
					<p class="theme-author">
						&nbsp;&nbsp;&nbsp;&nbsp;<span id="info-invoice-info">jhkjhkj</span>			
					</p>							
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="row" value="0">
<input type="hidden" id="all" name="all" value="<?php echo $allcount ?>" />
<script type="text/javascript">
	var searchText ="";
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
					var shop = jQuery("#shop").val();
    				jQuery.ajax({
						url: "<?php echo plugin_dir_url( __FILE__) ?>/ajax-shop.php",
						type: "post",
						data: {
							row:row,
							search:search,
							shop:shop,
							page:'client'
						},
						/* remind that 'data' is the response of the AjaxController */
						success: function (data) {
							if(data == 'no')
								return;
							if(data.length < 1)
								return;
							// console.log(data);
							displayResult1(JSON.parse(data));
						},
						error: function (data, textStatus, errorThrown) {
							console.log(data);
						},
					});
    			}
			}
		});

		jQuery("body").on("click", ".result_m_item", function(e) {
			var id = jQuery(this).data('id');
			location.href = 'admin.php?page=ms-ordering-client-add&i='+id;
		});
		jQuery("body").on("keydown", "#search_shop", function(e) {
			searchText = jQuery(this).val();
		});
		jQuery("body").on("keyup", "#search_shop", function(e) {
			var search = jQuery("#search_shop").val();
			var shop = jQuery("#shop").val();
			if(searchText == search)
				return;
			jQuery('#row').val(0);
			jQuery.ajax({
				url: "<?php echo plugin_dir_url( __FILE__) ?>/ajax-shop.php",
				type: "post",
				data: {
					row:0,
					search:search,
					shop:shop,
					ajax:'ajax',
					to:'client'
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
				},
				error: function (data, textStatus, errorThrown) {
					console.log(data);
				},
			});
		});

		jQuery("body").on("change", "#shop", function(e) {
			var search = jQuery("#search_shop").val();
			var shop = jQuery("#shop").val();
			jQuery('#row').val(0);
			jQuery.ajax({
				url: "<?php echo plugin_dir_url( __FILE__) ?>/ajax-shop.php",
				type: "post",
				data: {
					row:0,
					search:search,
					shop:shop,
					ajax:'ajax',
					to:'client'
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
				},
				error: function (data, textStatus, errorThrown) {
					console.log(data);
				},
			});
		});
	});
	function displayResult(data){
		jQuery('.result_m_list').html('');	
		for(var i=0;i<data.length;i++){	
			var result=  '';
			result += '<div class="result_m_item col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 mb-1 p-2" data-id="'+data[i].id+'"><div class="agency_item"><div class="mb-2 item_img_div">';
	        result += '<img src="'.plugin_dir_url( __FILE__).'/assets/client/'+data[i].img+'">';
	        result += '</div>';
	        result += '<div class="col-12 item p-2">';
	        result += '<div class="item-content">';
	        result += 'サロン名 : '+data[i].name+'</div>';
	        result += '<div class="item-content">';
	        result += '取扱代理店 : '+data[i].shop+'</div>';
	        result += '<div class="item-content">';
	        result += '住所 : '+data[i].address+'</div>';
	        result += '<div class="item-content">';
	        result += '電話番号 : '+data[i].tel+'</div>';
	        result += '<div class="item-content">';
	        result += 'E-mail : '+data[i].mail+'</div>';
	        result += '<div class="item-content">';
	        result += '配送先住所 : '+data[i].shipping_info+'</div></div></div></div>';
			jQuery('.result_m_list').append(result);
		}
	}
	function displayResult1(data){
		// jQuery('.result_m_list').html('');	
		for(var i=0;i<data.length;i++){	
			var result=  '';
			result += '<div class="result_m_item col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 mb-1 p-2" data-id="'+data[i].id+'"><div class="agency_item"><div class="mb-2 item_img_div">';
	        result += '<img src="'.echo plugin_dir_url( __FILE__).'/assets/client/'+data[i].img+'">';
	        result += '</div>';
	        result += '<div class="col-12 item p-2">';
	        result += '<div class="item-content">';
	        result += 'サロン名 : '+data[i].name+'</div>';
	        result += '<div class="item-content">';
	        result += '取扱代理店 : '+data[i].shop+'</div>';
	        result += '<div class="item-content">';
	        result += '住所 : '+data[i].address+'</div>';
	        result += '<div class="item-content">';
	        result += '電話番号 : '+data[i].tel+'</div>';
	        result += '<div class="item-content">';
	        result += 'E-mail : '+data[i].mail+'</div>';
	        result += '<div class="item-content">';
	        result += '配送先住所 : '+data[i].shipping_info+'</div></div></div></div>';
			jQuery('.result_m_list').append(result);
		}
	}
</script>