$(function() {
	$.ajaxSetup({ cache: false });
	
	$("[href=#]").click(function() { return false; });
	
	// fades out flash message automatically
	$(".navbar .alert").delay(10000).fadeOut();
	
	// tooltips and popovers
	$("[data-toggle=popover]").popover();
	$("[data-toggle=tooltip]").tooltip();
	
	// triggers dropdowns
	$('.dropdown-toggle').dropdown();
	
	// ajax pagination more
	$("body").on("click", ".pagination-more a", function() {
		var a = $(this);
		if (a.hasClass("disabled") || a.is("[disabled]")) return false;	
		
		$(".pagination-more .btn[rel=tooltip]").tooltip("hide");
		a
			.removeClass()
			.addClass(a.attr("data-static-classes"))
			.button("loading");
		
		var url = $(this).attr("href");
		$.get(url, function(data) {
			// getting html chunks for tbody and .pagination-more respectively
			var html = $('<div />').html(data);
			var content = html.find('tbody.ajax-content').html();
			var paginator = html.find('.pagination-more').html();
			
			$("tbody.ajax-content").append(content);
			$(".pagination-more").html(paginator);
			
			$("body").trigger("rebind");
		});
		
		return false;
	});
	
	// trims input
	$("body").on("change", "input[type=text]", function() {
		var input = $(this);
		input.val( $.trim(input.val()) );
	});
});