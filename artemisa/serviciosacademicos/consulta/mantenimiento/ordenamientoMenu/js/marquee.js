	<script type="text/javascript">
	/************************************************************************************************************
	(C) www.dhtmlgoodies.com, October 2005
	
	This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.	
	
	Terms of use:
	You are free to use this script as long as the copyright message is kept intact. However, you may not
	redistribute, sell or repost it without our permission.
	
	Thank you!
	
	www.dhtmlgoodies.com
	Alf Magne Kalleland
	
	************************************************************************************************************/	
	var dhtmlgoodies_marqueeSteps = 2;	// Higher = Faster, Lower = slower and more smoothly
	var dhtmlgoodies_marqueeSpeed = 8;	// Lower value = Faster
	var dhtmlgoodies_marqueeStopOnMouseOver = false;	// Make the marquee stop moving when user moves his mouse over it
	var dhtmlgoodies_marqueePosition = 'bottom';	// "top" or "bottom"
	
	/* Don't change anything below here */
	var dhtmlgoodies_marqueeObj;
	var dhtmlgoodies_marqueeTextObj;
	var dhtmlgoodies_marqueeTmpStep;
	var dhtmlgoodies_marqueeTextObjects = new Array();
	var dhtmlgoodies_marqueeHiddenSpans = new Array();
	
	var dhtmlgoodies_marqueeIndex = 0;
	function repositionMarquee(e,timeout)
	{
		if(document.all)e=event;
		if(dhtmlgoodies_marqueePosition.toLowerCase()=='top'){
			dhtmlgoodies_marqueeObj.style.top = '0px';
		}else{
			dhtmlgoodies_marqueeObj.style.bottom = '-1px';
		}
		if(document.all && !timeout)setTimeout('repositionMarquee(false,true)',500)
	}
	function marqueeMove()
	{
		var leftPos = dhtmlgoodies_marqueeTextObj.offsetLeft;
		leftPos = leftPos - dhtmlgoodies_marqueeTmpStep;
		var rightEdge = leftPos + dhtmlgoodies_marqueeHiddenSpans[dhtmlgoodies_marqueeIndex].offsetLeft;
		if(rightEdge<0){
			leftPos = document.documentElement.offsetWidth;
			dhtmlgoodies_marqueeTextObj.style.display='none';
			dhtmlgoodies_marqueeIndex++;
			if(dhtmlgoodies_marqueeIndex>=dhtmlgoodies_marqueeTextObjects.length)dhtmlgoodies_marqueeIndex = 0;
			dhtmlgoodies_marqueeTextObj = dhtmlgoodies_marqueeTextObjects[dhtmlgoodies_marqueeIndex];
			dhtmlgoodies_marqueeTextObj.style.display='block';
			
		}
		dhtmlgoodies_marqueeTextObj.style.left = leftPos + 'px';
		
	}
	
	function stopMarqueeMove()
	{
		if(dhtmlgoodies_marqueeStopOnMouseOver)dhtmlgoodies_marqueeTmpStep = 0;		
	}
	function resumeMarqueeMove()
	{
		dhtmlgoodies_marqueeTmpStep = dhtmlgoodies_marqueeSteps;
	}
	function initMarquee()
	{
		dhtmlgoodies_marqueeObj = document.getElementById('dhtmlgoodies_marquee');
		
		var spans = dhtmlgoodies_marqueeObj.getElementsByTagName('DIV');
		for(var no=0;no<spans.length;no++){
			if(spans[no].className=='textObj'){
				if(!dhtmlgoodies_marqueeTextObj){
					dhtmlgoodies_marqueeTextObj = spans[no]; 
					spans[no].style.display='block';
				}else spans[no].style.display='none';
				dhtmlgoodies_marqueeTextObjects.push(spans[no]);
				var hiddenSpan = document.createElement('SPAN');
				hiddenSpan.innerHTML = ' '
				spans[no].appendChild(hiddenSpan);
				dhtmlgoodies_marqueeHiddenSpans.push(hiddenSpan);
				
			}
		}
		if(dhtmlgoodies_marqueePosition.toLowerCase()=='top'){
			dhtmlgoodies_marqueeObj.style.top = '0px';
		}else{
			if(document.all){
				dhtmlgoodies_marqueeObj.style.bottom = '0px';
			}else{
				dhtmlgoodies_marqueeObj.style.bottom = '-1px';
			}
		}
		


		
		dhtmlgoodies_marqueeObj.style.display='block';
		dhtmlgoodies_marqueeTextObj.style.left = document.documentElement.offsetWidth + 'px';
		dhtmlgoodies_marqueeObj.onmouseover = stopMarqueeMove;
		dhtmlgoodies_marqueeObj.onmouseout = resumeMarqueeMove;
		if(document.all)window.onscroll = repositionMarquee; else dhtmlgoodies_marqueeObj.style.position = 'fixed';
		
		dhtmlgoodies_marqueeObj.style.display='block';
		dhtmlgoodies_marqueeTmpStep = dhtmlgoodies_marqueeSteps;
		
		setInterval('marqueeMove()',dhtmlgoodies_marqueeSpeed);
	}
	
	</script>
<SCRIPT type=text/javascript>
	/************************************************************************************************************
	(C) www.dhtmlgoodies.com, October 2005
	
	This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.	
	
	Terms of use:
	You are free to use this script as long as the copyright message is kept intact. However, you may not
	redistribute, sell or repost it without our permission.
	
	Thank you!
	
	www.dhtmlgoodies.com
	Alf Magne Kalleland
	
	************************************************************************************************************/	
	var dhtmlgoodies_marqueeSteps = 2;	// Higher = Faster, Lower = slower and more smoothly
	var dhtmlgoodies_marqueeSpeed = 8;	// Lower value = Faster
	var dhtmlgoodies_marqueeStopOnMouseOver = false;	// Make the marquee stop moving when user moves his mouse over it
	var dhtmlgoodies_marqueePosition = 'bottom';	// "top" or "bottom"
	
	/* Don't change anything below here */
	var dhtmlgoodies_marqueeObj;
	var dhtmlgoodies_marqueeTextObj;
	var dhtmlgoodies_marqueeTmpStep;
	var dhtmlgoodies_marqueeTextObjects = new Array();
	var dhtmlgoodies_marqueeHiddenSpans = new Array();
	
	var dhtmlgoodies_marqueeIndex = 0;
	function repositionMarquee(e,timeout)
	{
		if(document.all)e=event;
		if(dhtmlgoodies_marqueePosition.toLowerCase()=='top'){
			dhtmlgoodies_marqueeObj.style.top = '0px';
		}else{
			dhtmlgoodies_marqueeObj.style.bottom = '-1px';
		}
		if(document.all && !timeout)setTimeout('repositionMarquee(false,true)',500)
	}
	function marqueeMove()
	{
		var leftPos = dhtmlgoodies_marqueeTextObj.offsetLeft;
		leftPos = leftPos - dhtmlgoodies_marqueeTmpStep;
		var rightEdge = leftPos + dhtmlgoodies_marqueeHiddenSpans[dhtmlgoodies_marqueeIndex].offsetLeft;
		if(rightEdge<0){
			leftPos = document.documentElement.offsetWidth;
			dhtmlgoodies_marqueeTextObj.style.display='none';
			dhtmlgoodies_marqueeIndex++;
			if(dhtmlgoodies_marqueeIndex>=dhtmlgoodies_marqueeTextObjects.length)dhtmlgoodies_marqueeIndex = 0;
			dhtmlgoodies_marqueeTextObj = dhtmlgoodies_marqueeTextObjects[dhtmlgoodies_marqueeIndex];
			dhtmlgoodies_marqueeTextObj.style.display='block';
			
		}
		dhtmlgoodies_marqueeTextObj.style.left = leftPos + 'px';
		
	}
	
	function stopMarqueeMove()
	{
		if(dhtmlgoodies_marqueeStopOnMouseOver)dhtmlgoodies_marqueeTmpStep = 0;		
	}
	function resumeMarqueeMove()
	{
		dhtmlgoodies_marqueeTmpStep = dhtmlgoodies_marqueeSteps;
	}
	function initMarquee()
	{
		dhtmlgoodies_marqueeObj = document.getElementById('dhtmlgoodies_marquee');
		
		var spans = dhtmlgoodies_marqueeObj.getElementsByTagName('DIV');
		for(var no=0;no<spans.length;no++){
			if(spans[no].className=='textObj'){
				if(!dhtmlgoodies_marqueeTextObj){
					dhtmlgoodies_marqueeTextObj = spans[no]; 
					spans[no].style.display='block';
				}else spans[no].style.display='none';
				dhtmlgoodies_marqueeTextObjects.push(spans[no]);
				var hiddenSpan = document.createElement('SPAN');
				hiddenSpan.innerHTML = '&nbsp;'
				spans[no].appendChild(hiddenSpan);
				dhtmlgoodies_marqueeHiddenSpans.push(hiddenSpan);
				
			}
		}
		if(dhtmlgoodies_marqueePosition.toLowerCase()=='top'){
			dhtmlgoodies_marqueeObj.style.top = '0px';
		}else{
			if(document.all){
				dhtmlgoodies_marqueeObj.style.bottom = '0px';
			}else{
				dhtmlgoodies_marqueeObj.style.bottom = '-1px';
			}
		}
		


		
		dhtmlgoodies_marqueeObj.style.display='block';
		dhtmlgoodies_marqueeTextObj.style.left = document.documentElement.offsetWidth + 'px';
		dhtmlgoodies_marqueeObj.onmouseover = stopMarqueeMove;
		dhtmlgoodies_marqueeObj.onmouseout = resumeMarqueeMove;
		if(document.all)window.onscroll = repositionMarquee; else dhtmlgoodies_marqueeObj.style.position = 'fixed';
		
		dhtmlgoodies_marqueeObj.style.display='block';
		dhtmlgoodies_marqueeTmpStep = dhtmlgoodies_marqueeSteps;
		
		setInterval('marqueeMove()',dhtmlgoodies_marqueeSpeed);
	}
	
	</SCRIPT>