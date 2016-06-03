$(document).ready(function () {
	if(document.location.hash.substring(1)) {
		$item = $("article[data-hid='"+document.location.hash.substring(1)+"']");
		Vostok.scrollTo($item,500,100);
	}
});

