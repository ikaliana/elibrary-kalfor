<script type="text/javascript">
	$(".form-check-input").on("change", function(e,a) {
		var class_name = $(this).val();
		//var class_attr = ($(this).is(':checked')) ? "flex" : "none";
		//$("li." + class_name).css("display",class_attr);

		if($(this).is(':checked')) $("li." + class_name).removeClass("filtered");
		else $("li." + class_name).addClass("filtered");

		pagination2.rebuild();
		SetPage(1);
		//$(".pagination").find("a").on("click",PageClick);
	});
</script>
