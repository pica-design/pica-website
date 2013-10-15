$(document).ready(function(){
	//We need to set our canvas height on the fly since our child image is positioned absolutely 
	var canvas = $('#canvas')
	var img = new Image();
	$(img).load(function(){
		canvas.css('height', $('#background').height());
	}).attr('src', 'images/PICA_Holidaysite2010_C_blend.jpg');
	$(window).resize(function(){ 
		canvas.css('height', $('#background').height()); 
		$('#Cassanova').css('top', '-' + $('#Cassanova').height() + 'px')
		$('#Roberto').css('top', '-' + $('#Roberto').height() + 'px')
	});
	//Lets go ahead and load our rollover state images, and the tooltip images
	var onImages = new Array('Checked-Tree-On.png', 'Ornamental-Tree-On.png', 'Argyle-Tree-On.png', 'Snowman-Tree-On.png', 'Polkadots-Tree-On.png', 'TT-BottomLeft-Bottom.png', 'TT-BottomLeft-Center.png', 'TT-BottomLeft-Top.png', 'TT-BottomRight-Bottom.png', 'TT-BottomRight-Center.png', 'TT-BottomRight-Top.png', 'TT-TopLeft-Bottom.png', 'TT-TopLeft-Center.png', 'TT-TopLeft-Top.png', 'TT-TopRight-Bottom.png', 'TT-TopRight-Center.png', 'TT-TopRight-Top.png')
	$(onImages).each(function(i){
		var onImage = new Image();
		$(onImage).load().attr('src', 'images/' + onImages[i]);
	});
	//jQuery plugin to swap bind hover states to our trees, and swap their sources
	$.fn.swapSrc = function () {
		$(this).hover(function(){
			//Remove the extension from the image src
			var src = $(this).attr('src').split('.png')
			//Lets store this value along with the image data
			$(this).data('name', src[0])
			//Set the new image source	
			$(this).attr('src', src[0] + '-On.png')
		}, function() {
			$(this).attr('src', $(this).data('name') + '.png')
			$(this).removeData('name')
		});
	}
	//Bind hover states and image swaps
	$('#CheckedTree').swapSrc();
	$('#OrnamentalTree').swapSrc();
	$('#ArgyleTree').swapSrc();
	$('#SnowmanTree').swapSrc();
	$('#PolkadotTree').swapSrc();
	//Bind our tooltips to their respective snowflakes
	$('.Snowflake').each(function(i){
		$(this).hover(function(){
			//Onmouseover Show Tooltip
			var FlakePos = $(this).position()
			var Tooltip = $('#' + $(this).attr('id') + '-Tooltip')
			//Look at snowflake position on screen
			//Look at tooltip height
			//Determine which position class below to use
			if (FlakePos.top < 180) { var y = 'Top' } else { var y = 'Bottom' }
			if (FlakePos.left < 308) { var x = 'Left' } else { var x = 'Right' }
			var TooltipPosition = y + x
			$(Tooltip).attr('class', 'Tooltip')
			$(Tooltip).addClass(TooltipPosition)
			//Each tooltip position requires different math for placing the tooltip correctly near the calling element
			switch (TooltipPosition) {
				case 'TopLeft':
					Tooltip.css('top', (FlakePos.top + ($(this).height() / 2) + 5))
					Tooltip.css('left', (FlakePos.left + ($(this).width() / 1.5) + 10))
				break;
				case 'TopRight':
					Tooltip.css('top', (FlakePos.top + $(this).height()) - 20)
					Tooltip.css('left', FlakePos.left - 285)
				break;
				case 'BottomLeft': 		
					Tooltip.css('top', (FlakePos.top - Tooltip.height() + ($(this).height() / 4) + 5))
					Tooltip.css('left', (FlakePos.left + $(this).width() / 1.5))
				break;
				case 'BottomRight':
					Tooltip.css('top', (FlakePos.top - Tooltip.height() + ($(this).height() / 4) + 15))
					Tooltip.css('left', FlakePos.left - 290)
				break;
			}
			Tooltip.show()
			//Save the tooltip 
			$(this).data('Tooltip', Tooltip)
		}, function() {
			//Onmouseout Remove Tooltip
			$(this).data('Tooltip').hide()
			$(this).removeData('Tooltip')
		});
	});
	
	$('#WelcomeText').hover(function(){
		$('#Cassanova').show().animate({'top': 0}, 1100, 'swing');	
		$('#Roberto').show().animate({'top': 0}, 1400, 'swing');							 
	}, function() {
		$('#Cassanova').animate({'top': '-' + $('#Cassanova').height() + 'px'}, 1200, 'swing');	
		$('#Roberto').animate({'top': '-' + $('#Roberto').height() + 'px'}, 1600, 'swing');	
	});
	
	/*
	//Show bossman ornaments
	var hiConfig = {
		sensitivity: 1,
		interval: 200, 
		timeout: 200,
		over: function() {
			$('#Cassanova').show().animate({'top': 0}, 1100, 'swing');	
			$('#Roberto').show().animate({'top': 0}, 1400, 'swing');	
		},
		out: function() {
			$('#Cassanova').animate({'top': '-' + $('#Cassanova').height() + 'px'}, 1200, 'swing');	
			$('#Roberto').animate({'top': '-' + $('#Roberto').height() + 'px'}, 1600, 'swing');	
		}
	}
	$('#WelcomeText').hoverIntent(hiConfig)
	*/
});