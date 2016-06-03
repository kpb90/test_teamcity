$(document).ready(function () {

	$('#content').on('click','#partner-list .content .more a', function (e) {
		e.preventDefault();
		var a = $(this);
		$(a).toggleClass('active');
		$(a).closest('article').toggleClass('active');
		var content = $(a).closest('.content');
		if($(content).hasClass('full')) {
			content.removeClass('full');
			if(a.hasClass('en_')) a.html('Expand');
			else a.html('Читать далeе');
		}
		else {
			content.addClass('full');
			if(a.hasClass('en_')) a.html('Hide');
			else a.html('Свернуть');
		}

	});


});

