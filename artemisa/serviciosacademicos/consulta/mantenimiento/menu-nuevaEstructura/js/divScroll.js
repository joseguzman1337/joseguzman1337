
	<script type="text/javascript">
	/************************************************************************************************************
	(C) www.dhtmlgoodies.com, September 2005
	
	This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.	
	
	Terms of use:
	You are free to use this script as long as the copyright message is kept intact. However, you may not
	redistribute, sell or repost it without our permission.
	
	Thank you!
	
	www.dhtmlgoodies.com
	Alf Magne Kalleland
	
	************************************************************************************************************/	
	var contentHeight = 0; 	// The total height of the content
	var visibleContentHeight = 0;	
	var scrollActive = false;
	
	var scrollHandleObj = false; // reference to the scroll handle
	var scrollHandleHeight = false;
	var scrollbarTop = false;
	var eventYPos = false;

	var scrollbuttonActive = false;
	var scrollbuttonDirection = false;
	var scrollbuttonSpeed = 2; // How fast the content scrolls when you click the scroll buttons(Up and down arrows)
	var scrollTimer = 10;	// Also how fast the content scrolls. By decreasing this value, the content will move faster	
	
	var scrollMoveToActive = false;
	var scrollMoveToYPosition = false;
	function scrollDiv_startScroll(e)
	{
		if(document.all)e = event;
		scrollbarTop = document.getElementById('scrolldiv_theScroll').offsetTop;
		eventYPos = e.clientY;
		scrollActive = true;
	}
	
	function scrollDiv_stopScroll()
	{
		scrollActive = false;
		scrollbuttonActive = false;
		scrollMoveToActive = false;
	}
	function scrollDiv_scroll(e)
	{
		if(!scrollActive)return;
		if(document.all)e = event;
		if(e.button!=1 && document.all)return;
		var topPos = scrollbarTop + e.clientY - eventYPos; 
		if(topPos<0)topPos=0;
		if(topPos/1>visibleContentHeight-(scrollHandleHeight+4)/1)topPos = visibleContentHeight-(scrollHandleHeight+4);
		document.getElementById('scrolldiv_theScroll').style.top = topPos + 'px';
		document.getElementById('scrolldiv_content').style.top = 0 - Math.floor((contentHeight) * ((topPos)/(visibleContentHeight-scrollHandleHeight)))+'px' 
	}
	
	/*
	Click on the slider
	Move the content to the this point
	*/
	function scrolldiv_scrollMoveToInit(e)
	{		
		if(document.all)e = event;
		scrollMoveToActive = true;
		scrollMoveToYPosition = e.clientY - document.getElementById('scrolldiv_scrollbar').offsetTop;
		if(document.getElementById('scrolldiv_theScroll').offsetTop/1 > scrollMoveToYPosition) scrollbuttonDirection = scrollbuttonSpeed*-2; else  scrollbuttonDirection = scrollbuttonSpeed*2;
		scrolldiv_scrollMoveTo();	
	}
	
	function scrolldiv_scrollMoveTo()
	{
		if(!scrollMoveToActive || scrollActive)return;
		var topPos = document.getElementById('scrolldiv_theScroll').style.top.replace('px','');
		topPos = topPos/1 + scrollbuttonDirection;
		if(topPos<0){
			topPos=0;
			scrollMoveToActive=false;
		}
		if(topPos/1>visibleContentHeight-(scrollHandleHeight+4)/1){
			topPos = visibleContentHeight-(scrollHandleHeight+4);	
			scrollMoveToActive=false;
		}
		if(scrollbuttonDirection<0 && topPos<scrollMoveToYPosition-scrollHandleHeight/2)return;	
		if(scrollbuttonDirection>0 && topPos>scrollMoveToYPosition-scrollHandleHeight/2)return;			
		document.getElementById('scrolldiv_theScroll').style.top = topPos + 'px';
		document.getElementById('scrolldiv_content').style.top = 0 - Math.floor((contentHeight) * ((topPos)/(visibleContentHeight-scrollHandleHeight)))+'px' 		
		setTimeout('scrolldiv_scrollMoveTo()',scrollTimer);		
	}
	
	function cancelEvent()
	{
		return false;			
	}

	function scrolldiv_scrollButton()
	{
		if(this.id=='scrolldiv_scrollDown')scrollbuttonDirection = scrollbuttonSpeed; else scrollbuttonDirection = scrollbuttonSpeed*-1;
		scrollbuttonActive=true;
		scrolldiv_scrollButtonScroll();
	}
	function scrolldiv_scrollButtonScroll()
	{
		if(!scrollbuttonActive)return;
		var topPos = document.getElementById('scrolldiv_theScroll').style.top.replace('px','');
		topPos = topPos/1 + scrollbuttonDirection;
		if(topPos<0){
			topPos=0;
			scrollbuttonActive=false;
		}
		if(topPos/1>visibleContentHeight-(scrollHandleHeight+4)/1){
			topPos = visibleContentHeight-(scrollHandleHeight+4);	
			scrollbuttonActive=false;
		}	
		document.getElementById('scrolldiv_theScroll').style.top = topPos + 'px';
		document.getElementById('scrolldiv_content').style.top = 0 - Math.floor((contentHeight) * ((topPos)/(visibleContentHeight-scrollHandleHeight)))+'px' 			
		setTimeout('scrolldiv_scrollButtonScroll()',scrollTimer);
	}
	function scrolldiv_scrollButtonStop()
	{
		scrollbuttonActive = false;
	}
	
	
	function scrolldiv_initScroll()
	{
		visibleContentHeight = document.getElementById('scrolldiv_scrollbar').offsetHeight ;
		contentHeight = document.getElementById('scrolldiv_content').offsetHeight - visibleContentHeight;		
		scrollHandleObj = document.getElementById('scrolldiv_theScroll');
		scrollHandleHeight = scrollHandleObj.offsetHeight;
		scrollbarTop = document.getElementById('scrolldiv_scrollbar').offsetTop;		
		document.getElementById('scrolldiv_theScroll').onmousedown = scrollDiv_startScroll;
		document.body.onmousemove = scrollDiv_scroll;
		document.getElementById('scrolldiv_scrollbar').onselectstart = cancelEvent;
		document.getElementById('scrolldiv_theScroll').onmouseup = scrollDiv_stopScroll;
		if(document.all)document.body.onmouseup = scrollDiv_stopScroll; else document.documentElement.onmouseup = scrollDiv_stopScroll;
		document.getElementById('scrolldiv_scrollDown').onmousedown = scrolldiv_scrollButton;
		document.getElementById('scrolldiv_scrollUp').onmousedown = scrolldiv_scrollButton;
		document.getElementById('scrolldiv_scrollDown').onmouseup = scrolldiv_scrollButtonStop;
		document.getElementById('scrolldiv_scrollUp').onmouseup = scrolldiv_scrollButtonStop;
		document.getElementById('scrolldiv_scrollUp').onselectstart = cancelEvent;
		document.getElementById('scrolldiv_scrollDown').onselectstart = cancelEvent;
		document.getElementById('scrolldiv_scrollbar').onmousedown = scrolldiv_scrollMoveToInit;
	}
	/*
	Change from the default color
	*/	
	function scrolldiv_setColor(rgbColor)
	{
		document.getElementById('scrolldiv_scrollbar').style.borderColor = rgbColor;
		document.getElementById('scrolldiv_theScroll').style.backgroundColor = rgbColor;
		document.getElementById('scrolldiv_scrollUp').style.borderColor = rgbColor;
		document.getElementById('scrolldiv_scrollDown').style.borderColor = rgbColor;
		document.getElementById('scrolldiv_scrollUp').style.color = rgbColor;
		document.getElementById('scrolldiv_scrollDown').style.color = rgbColor;
		document.getElementById('scrolldiv_parentContainer').style.borderColor = rgbColor;
	}
	/*
	Setting total width of scrolling div
	*/
	function scrolldiv_setWidth(newWidth)
	{
		document.getElementById('dhtmlgoodies_scrolldiv').style.width = newWidth + 'px';
		document.getElementById('scrolldiv_parentContainer').style.width = newWidth-30 + 'px';		
	}
	
	/*
	Setting total height of scrolling div
	*/
	function scrolldiv_setHeight(newHeight)
	{
		document.getElementById('dhtmlgoodies_scrolldiv').style.height = newHeight + 'px';
		document.getElementById('scrolldiv_parentContainer').style.height = newHeight + 'px';
		document.getElementById('scrolldiv_slider').style.height = newHeight + 'px';
		document.getElementById('scrolldiv_scrollbar').style.height = newHeight-40 + 'px';		
	}
	/*
	Setting new background color to the slider 
	*/
	function setSliderBgColor(rgbColor)
	{
		document.getElementById('scrolldiv_scrollbar').style.backgroundColor = rgbColor;
		document.getElementById('scrolldiv_scrollUp').style.backgroundColor = rgbColor;
		document.getElementById('scrolldiv_scrollDown').style.backgroundColor = rgbColor;
	}
	/*
	Setting new content background color
	*/
	function setContentBgColor(rgbColor)
	{
		document.getElementById('scrolldiv_parentContainer').style.backgroundColor = rgbColor;
	}
	
	/*
	Setting scroll button speed
	*/
	function setScrollButtonSpeed(newScrollButtonSpeed)
	{
		scrollbuttonSpeed = newScrollButtonSpeed;
	}
	/*
	Setting interval of the scroll
	*/
	function setScrollTimer(newInterval)
	{
		scrollTimer = newInterval;
	}
	
	</script>
