<link href="../wp-content/plugins/membership-ordering-system/assets/css/sb-admin-2.min.css" rel="stylesheet" type="text/css">
<link href="../wp-content/plugins/membership-ordering-system/assets/css/agency.css" rel="stylesheet">
<?php
global $wpdb; 
$del = isset( $_POST['del'] ) ? absint( $_POST['del'] ) : 0;
if($del != 0){
	$ids = $_POST['post'];
	$ids_str = implode(',', $ids);
	$wpdb->query($wpdb->prepare("DELETE FROM wp_ms_client WHERE id in (".$ids_str.")"));
}

$paged = isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1;
$s = isset( $_GET['s'] ) ? $_GET['s'] : 0;
$a = isset( $_GET['a'] ) ? $_GET['a'] : '';

$wild = '%';
$like = $wild . $wpdb->esc_like( $a ) . $wild;
// echo $like;
$limit = 20; // number of rows in page
if($s != 0){
	$total = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(`id`) FROM `wp_ms_client` where shop_id  = '%d' and address like %s", array($s, $like)) );
}else{
	$total = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(`id`) FROM `wp_ms_client` where address like %s", $like) );
}
$num_of_pages = ceil( $total / $limit );
if($paged > $num_of_pages)
	$paged = $num_of_pages;
$offset = ( $paged - 1 ) * $limit;

if($s != 0){
	$posts = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_ms_client where shop_id  = '%d' and address like %s order by `time` desc LIMIT %d, %d", array($s, $like, $offset, $limit)));
}else
	$posts = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_ms_client where address like %s order by `time` desc LIMIT %d, %d", array($like, $offset, $limit)));



$shops = $wpdb->get_results("SELECT * FROM wp_ms_shop");
?>
<style type="text/css">	
    [type="number"]::-webkit-inner-spin-button,
    [type="number"]::-webkit-outer-spin-button {
       display:none;
    }
    table tbody tr td{
        word-break: break-word;
    }
    .check-column{
    	width: 5%;
    }
    .column-name{
    	width: 10%;
    }
    .column-shop{
    	width: 13%;
    }
    .column-address{
    	width: 25%;
    }
    .column-tel{
    	width: 12%;
    }
    .column-mail{
    	width: 15%;
    }
    .column-shipping_info{
    	width: 20%;
    }
    @media screen and (max-width: 1100px){
        .d-none1{
            display: none;
        }
        .column-name{
	    	width: 18%;
	    }
	    .column-address{
	    	width: 32%;
	    }
    }
    @media screen and (max-width: 768px){
        .d-none2{
            display: none;
        }
        .column-name{
	    	width: 40%;
	    }
	    .column-mail{
	    	width: 50%;
	    }
	    .check-column{
	    	width: 10%;
	    }
    }
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
	        <option value="<?php echo $shop->id ?>"
	            <?php
	                if($s == $shop->id)
	                    echo 'selected';                                    
	            ?>
	            ><?php echo $shop->shop_name ?></option>
	        <?php
	    }
	    ?>
	    </select>
		<input placeholder="住所検索" type="search" aria-describedby="live-search-desc" id="search_address" value="<?php echo $a ?>" class="wp-filter-search">
	</div>
</div>
<div class="wrap">
	<form method="post" name="shop_form" id="shop_form">
		<?php
		if($num_of_pages > 1){
		?>
		<div class="tablenav top">
			<div class="alignleft actions bulkactions">			
				<input type="button" class="button action item_delete" value="削除">
			</div>
			<div class="tablenav-pages">
				<span class="displaying-num"><?php echo number_format($total); ?> アイテム<!--  items --></span>
				<span class="pagination-links">
					<?php 
						if($paged <= 2){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>';
						}else{
							echo '<a class="first-page button" href="admin.php?page=ms-ordering-client&paged=1&s='.$s.'&a='.$a.'">';
							echo '<span class="screen-reader-text">First page</span><span aria-hidden="true">«</span></a>';
						}
						if($paged <= 1){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin-left:0.2em">‹</span>';
						}else{
							echo '<a class="prev-page button" href="admin.php?page=ms-ordering-client&paged='.($paged - 1).'&s='.$s.'&a='.$a.'" style="margin-left:0.2em">';
							echo '<span class="screen-reader-text">Previous page</span><span aria-hidden="true">‹</span></a>';
						}
					?>
					<span class="paging-input">
						<label for="current-page-selector" class="screen-reader-text">Current Page</label>
						<input class="current-page" id="current-page-selector" type="number" name="paged" value="<?php echo $paged ?>" aria-describedby="table-paging" style="width: 70px" max="<?php echo $num_of_pages ?>" min="1">
						<span class="tablenav-paging-text"> of <span class="total-pages"><?php echo number_format($num_of_pages); ?></span></span>
					</span>
					<?php					
						if($paged == $num_of_pages){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span>';
						}else{
							echo '<a class="prev-page button" href="admin.php?page=ms-ordering-client&paged='.($paged + 1).'&s='.$s.'&a='.$a.'">';
							echo '<span class="screen-reader-text">Next page</span><span aria-hidden="true">›</span></a>';
						}

						if($paged == $num_of_pages || $paged == ($num_of_pages - 1)){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin-left:0.2em">»</span>';
						}else{
							echo '<a class="last-page button" href="admin.php?page=ms-ordering-client&paged='.$num_of_pages.'&s='.$s.'&a='.$a.'" style="margin-left:0.2em">';
							echo '<span class="screen-reader-text">Last page</span><span aria-hidden="true">»</span></a>';
						}
					?>
				</span>
			</div>
		</div>
		<?php
		}else{
		?>
		<div class="tablenav top">
			<div class="alignleft actions bulkactions">
				<input type="button" class="button action item_delete" value="削除">
			</div>
			<div class="tablenav-pages one-page">
				<span class="displaying-num"><?php echo $total ?> アイテム</span>
			</div>
		</div>
		<?php
		}
		?>
		<table class="wp-list-table widefat fixed striped table-view-list posts">
		    <thead>
		        <tr>
		            <td id="cb" class="manage-column column-cb check-column"><input id="cb-select-all-1" type="checkbox"></td>
		            <th scope="col" class="manage-column column-name">サロン名</th>
		            <th scope="col" class="manage-column column-shop d-none1">取扱代理店</th>
		            <th scope="col" class="manage-column column-address d-none2">住所</th>
		            <th scope="col" class="manage-column column-tel d-none2">電話番号</th>
		            <th scope="col" class="manage-column column-mail">E-mail</th>
		            <th scope="col" class="manage-column column-shipping_info d-none2">配送先住所</th>
		        </tr>
		    </thead>
		    <tbody id="the-shop-list" class="shop_list_body"> 
		    	<?php        
			        $idx = 0;
			        if(!$posts || count($posts) < 1)
		                echo '<tr class="no-item"><td class="colspanchange" colspan="7">...</td></tr>';
		           	else
				        foreach($posts as $post){
				        	$idx++; 
				        	echo '<tr data-id="'.$post->id.'" class="h_item iedit author-self level-0 post-'.$post->id.' type-product status-publish has-post-thumbnail hentry product_cat-uncategorized">';
			                // echo '<td class="product_tag column-product_tag d-none1">'.$idx.'</td>';
			                echo '<th scope="row" class="check-column"><input class="shop_select" type="checkbox" name="post[]" value="'.$post->id.'"></th>';
			                echo '<td class="product_tag column-product_tag">';
			                echo '<strong><a href="admin.php?page=ms-ordering-client-add&i='.$post->id.'">'.$post->name.'</a><strong>';
			                echo '</td>';
			                echo '<td class="product_tag column-product_tag d-none1">'.$post->shop.'</td>';
			                echo '<td class="product_tag column-product_tag d-none2">'.$post->client_pref.'&nbsp;&nbsp;'.$post->client_city.'&nbsp;&nbsp;'.$post->address.'</td>';
			                echo '<td class="product_tag column-product_tag d-none2">'.$post->tel.'</td>';
			                echo '<td class="product_tag column-product_tag">';
			                echo '<a href="mailto:'.$post->mail.'">'.$post->mail.'</a>';
			                echo '</td>';
			                echo '<td class="product_tag column-product_tag d-none2">'.$post->shipping_info.'</td>';
			                echo '</tr>';
				        }
		        ?>
		    </tbody>
		    <tfoot>
		        <tr>
		            <td id="cb" class="manage-column column-cb check-column"><input id="cb-select-all-1" type="checkbox"></td>
		            <th scope="col" class="manage-column column-is_in_stock">サロン名</th>
		            <th scope="col" class="manage-column column-is_in_stock d-none1">取扱代理店</th>
		            <th scope="col" class="manage-column column-is_in_stock d-none2">住所</th>
		            <th scope="col" class="manage-column column-is_in_stock d-none2">電話番号</th>
		            <th scope="col" class="manage-column column-is_in_stock">E-mail</th>
		            <th scope="col" class="manage-column column-is_in_stock d-none2">配送先住所</th>
		        </tr>
		    </tfoot>
		</table>
	    <?php
		if($num_of_pages > 1){
		?>
		<div class="tablenav bottom">
			<div class="alignleft actions bulkactions">			
				<input type="button" class="button action item_delete" value="削除">
			</div>
			<div class="tablenav-pages">
				<span class="displaying-num"><?php echo number_format($total); ?> アイテム<!--  items --></span>
				<span class="pagination-links">
					<?php 
						if($paged <= 2){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>';
						}else{
							echo '<a class="first-page button" href="admin.php?page=ms-ordering-client&paged=1&s='.$s.'&a='.$a.'">';
							echo '<span class="screen-reader-text">First page</span><span aria-hidden="true">«</span></a>';
						}
						if($paged <= 1){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin-left:0.2em">‹</span>';
						}else{
							echo '<a class="prev-page button" href="admin.php?page=ms-ordering-client&paged='.($paged - 1).'&s='.$s.'&a='.$a.'" style="margin-left:0.2em">';
							echo '<span class="screen-reader-text">Previous page</span><span aria-hidden="true">‹</span></a>';
						}
					?>
					<span class="paging-input">
						<label for="current-page-selector" class="screen-reader-text">Current Page</label>
						<input class="current-page" id="current-page-selector" type="number" name="paged" value="<?php echo $paged ?>" aria-describedby="table-paging" style="width: 70px" max="<?php echo $num_of_pages ?>" min="1">
						<span class="tablenav-paging-text"> of <span class="total-pages"><?php echo number_format($num_of_pages); ?></span></span>
					</span>
					<?php					
						if($paged == $num_of_pages){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span>';
						}else{
							echo '<a class="prev-page button" href="admin.php?page=ms-ordering-client&paged='.($paged + 1).'&s='.$s.'&a='.$a.'">';
							echo '<span class="screen-reader-text">Next page</span><span aria-hidden="true">›</span></a>';
						}

						if($paged == $num_of_pages || $paged == ($num_of_pages - 1)){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin-left:0.2em">»</span>';
						}else{
							echo '<a class="last-page button" href="admin.php?page=ms-ordering-client&paged='.$num_of_pages.'&s='.$s.'&a='.$a.'" style="margin-left:0.2em">';
							echo '<span class="screen-reader-text">Last page</span><span aria-hidden="true">»</span></a>';
						}
					?>
				</span>
			</div>
		</div>
		<?php
		}else{
		?>
		<div class="tablenav bottom">
			<div class="alignleft actions bulkactions">			
				<input type="button" class="button action item_delete" value="削除">
			</div>
			<div class="tablenav-pages one-page">
				<span class="displaying-num"><?php echo $total ?> アイテム</span>
			</div>
		</div>
		<?php 
		}
		?>
		<input type="hidden" id="del" name="del" value="0">
	</form>
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
<script type="text/javascript">
	var searchText ="";
	jQuery(document).ready(function () {

		// jQuery("body").on("click", ".result_m_item", function(e) {
		// 	var id = jQuery(this).data('id');
		// 	location.href = 'admin.php?page=ms-ordering-client-add&i='+id;
		// });
		jQuery("body").on("keypress", ".current-page", function(e) {
			if(e.keyCode == 13){
				location.href = "admin.php?page=ms-ordering-client&paged="+jQuery(this).val()+"&s="+jQuery('#shop').val()+"&a="+jQuery('#search_address').val();
			}
		});
		jQuery("body").on("keypress", "#search_address", function(e) {
			if(e.keyCode != 13)
				return;
			var search = jQuery("#search_address").val();
			var shop = jQuery("#shop").val();
			location.href = "admin.php?page=ms-ordering-client&a="+search+"&s="+shop;
		});

		jQuery("body").on("change", "#shop", function(e) {
			var search = jQuery("#search_address").val();
			var shop = jQuery("#shop").val();
			location.href = "admin.php?page=ms-ordering-client&a="+search+"&s="+shop;
		});
		jQuery("body").on("click", ".item_delete", function(e) {
			var _select = 0;
			jQuery('.shop_select').each(function(){
				console.log(jQuery(this).prop('checked'));
				if(jQuery(this).prop('checked'))
					_select = 1;
			});
			if(_select == 0)
				return;
			jQuery('#del').val(1);
			jQuery('#shop_form').submit();
		});
	});
</script>