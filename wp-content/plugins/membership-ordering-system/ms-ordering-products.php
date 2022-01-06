<?php
global $wpdb; 
$del = isset( $_POST['del'] ) ? absint( $_POST['del'] ) : 0;
if($del != 0){
	$ids = $_POST['post'];
	$ids_str = implode(',', $ids);
	$wpdb->query($wpdb->prepare("DELETE FROM wp_ms_products WHERE id in (".$ids_str.")"));
}

$paged = isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1;
$s = isset( $_GET['s'] ) ? $_GET['s'] : 0;
$p = isset( $_GET['p'] ) ? $_GET['p'] : '';

$wild = '%';
$like = $wild . $wpdb->esc_like( $p ) . $wild;

$limit = 20; // number of rows in page
// if($s != 0){
// 	$total = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(`id`) FROM `wp_ms_products` where shop_id  = '%d' and name like %s", array($s, $like)) );
// }else{
	$total = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(`id`) FROM `wp_ms_products` where name like %s", $like) );
// }
$num_of_pages = ceil( $total / $limit );
if($paged > $num_of_pages)
	$paged = $num_of_pages;
$offset = ( $paged - 1 ) * $limit;

// if($s != 0){
// 	$products = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_ms_products where shop_id  = '%d' and name like %s order by `time` desc LIMIT %d, %d", array($s, $like, $offset, $limit)));
// }else
	$products = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_ms_products where name like %s order by `time` desc LIMIT %d, %d", array($like, $offset, $limit)));
// $products = $wpdb->get_results("SELECT * FROM wp_ms_products order by `time` desc limit 0, ".$rowperpage);

$shops = $wpdb->get_results("SELECT * FROM wp_ms_shop");
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
    .column-thumb{
    	width: 20%;
    }
    .column-name{
    	width: 15%;
    }
    .column-price{
    	width: 20%;
    }
    .column-comment{
    	width: 40%;
    }
    @media screen and (max-width: 1000px){
        .d-none1{
            display: none;
        }
	    .check-column{
	    	width: 10%;
	    }
	    .column-thumb{
	    	width: 30%;
	    }
	    .column-name{
	    	width: 25%;
	    }
	    .column-price{
	    	width: 35%;
	    }
    }
    @media screen and (max-width: 768px){
        .d-none2{
            display: none;
        }
	    .column-name{
	    	width: 45%;
	    }
	    .column-price{
	    	width: 45%;
	    }
    }
    .product_img{
    	margin: 0;
	    width: auto;
	    height: auto;
	    max-width: 40px;
	    max-height: 40px;
	    vertical-align: middle;
    }
    #search_product{
		float: right;
	    position: absolute;
	    bottom: 0px;
	    right: 0px;
	}
	@media screen and (max-width: 441px) {
		#search_product{
			position: unset !important;
			margin-bottom: 1rem;
		}
	}
</style>

<div class="wrap" style="position: relative;">
	<h1 class="wp-heading-inline">商品一覧</h1>	
	<a href="admin.php?page=ms-ordering-products-add" class="upload-view-toggle page-title-action" role="button" aria-expanded="false"><span class="upload">商品新規登録</span></a>
	<!-- <div style="float: right;display: flex;"> -->
		<!-- <select id="shop" name="shop" style="margin-right: 0.5rem">
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
	    </select> -->
		<input placeholder="検索" type="search" aria-describedby="live-search-desc" id="search_product" value="<?php echo $p ?>" class="wp-filter-search">
	<!-- </div> -->
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
							echo '<a class="first-page button" href="admin.php?page=ms-ordering-products&paged=1&s='.$s.'&p='.$p.'">';
							echo '<span class="screen-reader-text">First page</span><span aria-hidden="true">«</span></a>';
						}
						if($paged <= 1){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin-left:0.2em">‹</span>';
						}else{
							echo '<a class="prev-page button" href="admin.php?page=ms-ordering-products&paged='.($paged - 1).'&s='.$s.'&p='.$p.'" style="margin-left:0.2em">';
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
							echo '<a class="prev-page button" href="admin.php?page=ms-ordering-products&paged='.($paged + 1).'&s='.$s.'&p='.$p.'">';
							echo '<span class="screen-reader-text">Next page</span><span aria-hidden="true">›</span></a>';
						}

						if($paged == $num_of_pages || $paged == ($num_of_pages - 1)){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin-left:0.2em">»</span>';
						}else{
							echo '<a class="last-page button" href="admin.php?page=ms-ordering-products&paged='.$num_of_pages.'&s='.$s.'&p='.$p.'" style="margin-left:0.2em">';
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
		            <th scope="col" id="thumb" class="manage-column column-thumb d-none2"><span class="wc-image tips">Image</span></th>
		            <th scope="col" class="manage-column column-name">商品名</th>
		            <th scope="col" class="manage-column column-price">価格</th>
		            <th scope="col" class="manage-column column-comment d-none1">製品の簡単な説明</th>
		        </tr>
		    </thead>
		    <tbody id="the-shop-list" class="shop_list_body"> 
		    	<?php        
			        $idx = 0;
			        if(!$products || count($products) < 1)
		                echo '<tr class="no-item"><td class="colspanchange" colspan="5">...</td></tr>';
		           	else
				        foreach($products as $product){
				        	$idx++; 
				        	echo '<tr data-id="'.$product->id.'" class="h_item iedit author-self level-0 post-'.$product->id.' type-product status-publish has-post-thumbnail hentry product_cat-uncategorized">';
			                echo '<th scope="row" class="check-column"><input class="shop_select" type="checkbox" name="post[]" value="'.$product->id.'"></th>';
			                echo '<td class="thumb column-thumb d-none2" data-colname="Image">';
			                echo '<img width="150" height="150" src="../wp-content/plugins/membership-ordering-system/assets/product/'.$product->img.'" class="attachment-thumbnail size-thumbnail product_img" alt="" loading="lazy">';
			                echo '</td>';
			                echo '<td class="product_tag column-product_tag">';
			                echo '<strong><a href="admin.php?page=ms-ordering-products-add&i='.$product->id.'">'.$product->name.'</a><strong>';
			                echo '</td>';
			                echo '<td class="product_tag column-product_tag">';
			                if($product->sale != 0){
			                	echo '<del aria-hidden="true">'.number_format($product->regular).$product->currency.'</del>';
			                	echo '&nbsp;&nbsp;';
			                	echo '<ins><span>'.number_format($product->sale).$product->currency.'</span></ins>';
			                }else{
			                	echo '<span>'.number_format($product->regular).$product->currency.'</span>';
			                }
			                echo '</td>';
			                echo '<td class="product_tag column-product_tag d-none1">'.$product->comment.'</td>';
			                echo '</tr>';
				        }
		        ?>
		    </tbody>
		    <tfoot>
		        <tr>
		            <td id="cb" class="manage-column column-cb check-column" style="width: 5%"><input id="cb-select-all-1" type="checkbox"></td>
		            <th scope="col" id="thumb" class="manage-column column-thumb d-none2" style="width: 10%"><span class="wc-image tips">Image</span></th>
		            <th scope="col" class="manage-column column-is_in_stock" style="width: 15%">商品名</th>
		            <th scope="col" class="manage-column column-is_in_stock" style="width: 10%">価格</th>
		            <th scope="col" class="manage-column column-is_in_stock d-none1" style="width: 60%">製品の簡単な説明</th>
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
							echo '<a class="first-page button" href="admin.php?page=ms-ordering-products&paged=1&s='.$s.'&p='.$p.'">';
							echo '<span class="screen-reader-text">First page</span><span aria-hidden="true">«</span></a>';
						}
						if($paged <= 1){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin-left:0.2em">‹</span>';
						}else{
							echo '<a class="prev-page button" href="admin.php?page=ms-ordering-products&paged='.($paged - 1).'&s='.$s.'&p='.$p.'" style="margin-left:0.2em">';
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
							echo '<a class="prev-page button" href="admin.php?page=ms-ordering-products&paged='.($paged + 1).'&s='.$s.'&p='.$p.'">';
							echo '<span class="screen-reader-text">Next page</span><span aria-hidden="true">›</span></a>';
						}

						if($paged == $num_of_pages || $paged == ($num_of_pages - 1)){
							echo '<span class="tablenav-pages-navspan button disabled" aria-hidden="true" style="margin-left:0.2em">»</span>';
						}else{
							echo '<a class="last-page button" href="admin.php?page=ms-ordering-products&paged='.$num_of_pages.'&s='.$s.'&p='.$p.'" style="margin-left:0.2em">';
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
<script type="text/javascript">
	var searchText="";
	jQuery(document).ready(function () {

		jQuery("body").on("keypress", ".current-page", function(e) {
			if(e.keyCode == 13){
				location.href = "admin.php?page=ms-ordering-products&paged="+jQuery(this).val()+"&p="+jQuery('#search_product').val();
			}
		});
		jQuery("body").on("keypress", "#search_product", function(e) {
			if(e.keyCode != 13) return;
			var search = jQuery(this).val();
			// var shop = jQuery("#shop").val();
			location.href = "admin.php?page=ms-ordering-products&p="+search;
		});

		jQuery("body").on("change", "#shop", function(e) {
			var search = jQuery("#search_product").val();
			// var shop = jQuery("#shop").val();
			location.href = "admin.php?page=ms-ordering-products&p="+search;
		});
		jQuery("body").on("click", ".item_delete", function(e) {
			var _select = 0;
			jQuery('.shop_select').each(function(){
				// console.log(jQuery(this).prop('checked'));
				if(jQuery(this).prop('checked'))
					_select = 1;
			});
			if(_select == 0)
				return;
			if(confirm('削除しますか?')){
				jQuery('#del').val(1);
				jQuery('#shop_form').submit();
			}
		});
	});
</script>