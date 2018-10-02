bootbox.setDefaults({
	locale: "tr",
	show: true,
	backdrop: true,
	closeButton: true,
	animate: true,
	className: "my-modal"
});

function bootboxAlert(message, url)
{
	bootbox.confirm(message, function (result) {

		if (result)
		{
			self.document.location.href = url;
		}
	});
}