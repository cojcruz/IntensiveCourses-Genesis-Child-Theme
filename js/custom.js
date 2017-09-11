jQuery(function($) {

	$('#topbar .wc-ico-cart').append( '<span class="counter">' + getCartQty() + '</span>' );
	
	function getCartQty() {
	
		var qty = $('#topbar .cart_list').children().length;
		
		return qty;
		
	}
	
	var topbar = $('#topbar');
	
	$('#topbar').remove();
	$('.site-header').prepend( topbar );
	
	$('#featured-page-3 .entry:nth-child(2)').remove();
	
});