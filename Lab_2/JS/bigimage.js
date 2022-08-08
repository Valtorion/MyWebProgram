function UpImg(img)
{
  
      let path = img.getAttribute("src");
      path = path.replace("./Sorce/", "");
      path = path.replace("mini", "");

      let bigimg = document.getElementById("magnify").getElementsByTagName("img")[0];
      bigimg.setAttribute("src", "./Sorce/" + path);

      fadeIn("#overlay");
      fadeIn("#magnify");      
      
        
}

function fadeIn(el) {
  
	var opacity = 0.01;
	document.querySelector(el).style.display = "block";
  
	var timer = setInterval(function() {
    
    
		if(opacity >= 0.7 && el != "#magnify") {
			
			clearInterval(timer);
		
		}else
    {
      if (opacity >= 1)
      {
        clearInterval(timer);
      } 
    }
		
		document.querySelector(el).style.opacity = opacity;
     
		opacity += opacity * 0.1;
   
	}, 10);
	
}

function DonwImg()
{
      fadeOut("#overlay");
      fadeOut("#magnify");

      
}

function fadeOut(el) {
  
	var opacity = 1;
  
	var timer = setInterval(function() {
    
		if(opacity <= 0.1) {
		
			clearInterval(timer);
			document.querySelector(el).style.display = "none";
	
		}
	
		document.querySelector(el).style.opacity = opacity;
     
		opacity -= opacity * 0.1;
   
	}, 10);

}
/*


$(function(){
    $('.minimized').click(function(event) {
      
     });
      $('#overlay, #magnify').fadeIn('fast');
    });
    
    $('body').on('click', '#close-popup, #overlay', function(event) {
      event.preventDefault();
      $('#overlay, #magnify').fadeOut('fast', function() {
        $('#close-popup, #magnify, #overlay').remove();
      });
    });
  });*/