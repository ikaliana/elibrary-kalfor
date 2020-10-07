<script src="{{ asset('js/jquery.smFilteredPagination.js') }}"></script>
<script src="{{ asset('js/highlight.pack.js') }}"></script>

<script type="text/javascript">
	if (typeof jQuery.fn.live == 'undefined' || !(jQuery.isFunction(jQuery.fn.live))) {
		jQuery.fn.extend({
			live: function (event, callback) {
				// jQuery(document).on(event, this.selector, callback);
				if (this.selector) {
					jQuery(document).on(event, this.selector, callback);
				}
			}
		});
	}

	function SetPage(page) {
		pagination2.setCurrentPage(page);
		$(".pagination").find("a").on("click",PageClick);
	}

	function PageClick(e) {
		e.preventDefault();
		var target = $(this).attr("href");
		if(target.startsWith("#")) {
			target = target.replace("#","");
			if(!isNaN(target)) {
				SetPage(target);
			} 
			else {
				currentPage = pagination2.getCurrentPage();
				switch(target) {
					case "first":
						currentPage = "1";
						break;
					case "last":
						currentPage = pagination2.getPageCount();
						break;
					case "next":
						currentPage = eval(currentPage) + 1;
						break;
					case "prev":
						currentPage = eval(currentPage) - 1;
						break;
				}
				SetPage(currentPage);
			}
		}
	}

	$(function(){ // document ready
	    pagination2 = new $.smFilteredPagination($("#list-container"), {
	        pagerItems: "li.media",
	        pagerItemsWrapper: "ul.list-unstyled",
	        itemsPerPage: 10,
	        textFirst: "<<",
	        textPrev: "<",
	        textNext: ">",
	        textLast: ">>",
	        pagerClass: "pagination justify-content-center",
	        itemsInPager: 5, 
	        itemsInPagerEdge: 3,
	        showPagerHeader: false,
	        //scrollToTopOnChange: true,
	    });

	    $(".pagination").find("a").on("click",PageClick);
	});
</script>