$(document).ready(function(){

	var currentNotebook = '';
	var m = $('#menu');
	var x2 = $('.view').attr('href');

	$('.notebook').click(function(e){
		if(m.is(":visible")){
			m.fadeOut();
			setTimeout(function(){
				show(e.pageX, e.pageY);
			}, 500);
		} else {
			show(e.pageX, e.pageX);
		}


		var x = $(event.target).attr('class');
		currentNotebook = x.substring(x.indexOf(' ') + 1, x.length);
		currentNotebook = encodeURIComponent(currentNotebook);
		$('#new').attr('href', 'note.php?new&notebook=' + currentNotebook);
		$('.view').attr('href', x2 + currentNotebook); //only works if clicked div not span
	})


	function show(x, y){
		m.fadeIn();
		m.css({
			'position' : 'absolute',
			'top' : isNaN(y) ? 0 : (y - $('#menu').height()),
			'left' : isNaN(y) ? 0 : (x - $('#menu').width())
		});
	}
});