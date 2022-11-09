    
    $('select').select2();
    $('.carousel').carousel({
          interval: 2000
     });
    var images= document.querySelectorAll( ".content img" ),
	L = images.length, fig = document.createElement('figure'),
	who, temp
	while(L) {
		temp = fig.cloneNode(false);
		who = images[--L];
		caption = who.getAttribute("alt");
		who.parentNode.insertBefore(temp, who);
		content = document.createElement( 'figcaption' );
		content.innerHTML = caption;
		temp.appendChild(who);
		temp.appendChild(content);
	}
	$(".content img").attr("style", "width:350px;height:auto;");
	$(".content figcaption").attr("style", "width:350px;height:auto;");