function bindMandalaStructure(){

	$('.structure-1 .mandala a').on('click', function (e){

		e.preventDefault();

		$('.structure-1 .mandala a').removeClass('selected');
     	$(this).addClass('selected');

		url = BASE_URL + 'listing/sukta?mandala=' + $(this).attr('data-mandala');
	    $.get( url, function( data ) {
	        
	        if(data) {
	         	
				$('.structure-3').html( '' );
				$('.structure-2').html( data );
				bindMandalaStructure();
	        }
	    });
	});

	$('.structure-2 .sukta a').on('click', function (e){

		e.preventDefault();

		$('.structure-2 .sukta a').removeClass('selected');
     	$(this).addClass('selected');

		url = BASE_URL + 'listing/rikMandala?mandala=' + $(this).attr('data-mandala') + '&sukta=' + $(this).attr('data-sukta') ;
	    $.get( url, function( data ) {
	        
	        if(data) {
	         	
				$('.structure-3').html( data );
				delete myAudio;
			    embedAudioPlaylist();
	        }
	    });
	});
}

function bindAshtakaStructure(){

	$('.structure-1 .ashtaka a').on('click', function (e){

		e.preventDefault();

		$('.structure-1 .ashtaka a').removeClass('selected');
     	$(this).addClass('selected');

		url = BASE_URL + 'listing/adhyaya?ashtaka=' + $(this).attr('data-ashtaka');
	    $.get( url, function( data ) {
	        
	        if(data) {
	         	
				$('.structure-3').html( '' );
				$('.structure-4').html( '' );
				$('.structure-2').html( data );
				bindAshtakaStructure();
	        }
	    });
	});

	$('.structure-2 .adhyaya a').on('click', function (e){

		e.preventDefault();

		$('.structure-2 .adhyaya a').removeClass('selected');
     	$(this).addClass('selected');

		url = BASE_URL + 'listing/varga?ashtaka=' + $(this).attr('data-ashtaka') + '&adhyaya=' + $(this).attr('data-adhyaya') ;
	    $.get( url, function( data ) {
	        
	        if(data) {
	         	
				$('.structure-4').html( data );
				bindAshtakaStructure();
	        }
	    });
	});

	$('.structure-4 .varga a').on('click', function (e){

		e.preventDefault();

		$('.structure-4 .varga a').removeClass('selected');
     	$(this).addClass('selected');

		url = BASE_URL + 'listing/rikAshtaka?ashtaka=' + $(this).attr('data-ashtaka') + '&adhyaya=' + $(this).attr('data-adhyaya') + '&varga=' + $(this).attr('data-varga') ;
	    $.get( url, function( data ) {
	        
	        if(data) {
	         	
				$('.structure-3').html( data );
				delete myAudio;
				embedAudioPlaylist();
	        }
	    });
	});
}

function embedAudio() {

	$('.playPause').on('click', function(){

	    var id = $(this).attr('data-id');
	    var myAudio = document.getElementById(id);

	    if (myAudio.paused) {

	        myAudio.play();
	        $("#control-rikAudio").removeClass('fa-play-circle').addClass('fa-pause-circle').attr('title', 'Pause audio');
	    }
	    else {
	    
	        myAudio.pause();
	        $("#control-rikAudio").removeClass('fa-pause-circle').addClass('fa-play-circle').attr('title', 'Play audio');
	    }

	    $(myAudio).bind("ended", function(){

	        $("#control-rikAudio").removeClass('fa-pause-circle').addClass('fa-play-circle').attr('title', 'Play audio');
	    });
	});
}

function embedAudioPlaylist() {

	riks = '';
	$('.rikList li').each(function(){

		riks += ';' + $(this).attr('data-audio');
	});
	riks = riks.replace(/^;/, '').split(';');
	pointer = 0;
	
	$('.playPausePlaylist').on('click', function(){

		if(typeof myAudio === 'undefined') {

			myAudio = document.getElementById('audio-rik');

			myAudio.src = riks[pointer];
			bindOnEnded();
		    myAudio.load();
		}

		if (myAudio.paused) {

		    myAudio.play();
		    $("#control-rikAudio").removeClass('fa-play-circle').addClass('fa-pause-circle').attr('title', 'Pause audio');
		}
		else {
		
		    myAudio.pause();
		    $("#control-rikAudio").removeClass('fa-pause-circle').addClass('fa-play-circle').attr('title', 'Play audio');
		}

	});
}

function bindOnEnded(){

	$(myAudio).on("ended", function(){

		
		pointer++;
		if(pointer < riks.length) {
	
			myAudio.src = riks[pointer];
		    myAudio.load();
			myAudio.play();
		}
	});
}