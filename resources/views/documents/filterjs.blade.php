<script type="text/javascript">
	$(".form-check-input").on("change", function(e,a) {
		var class_name = $(this).val();
		var class_attr = ($(this).is(':checked')) ? "flex" : "none";

		$("li." + class_name).css("display",class_attr);
	});
</script>
