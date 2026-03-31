if(!window.DHTMLSuite)var DHTMLSuite=new Object();/************************************************************************************************************
*	Color functions
*
*	Created:		August, 23rd, 2006
*	@class Purpose of class:	This class provides some methods for working with colors.
*		
* 	Update log:
*
************************************************************************************************************/
/**
* @constructor
* @class This class provides some methods for working with colors.
* @version 1.0
* @author	Alf Magne Kalleland(www.dhtmlgoodies.com)
**/
DHTMLSuite.colorUtil=function(){	
}

DHTMLSuite.colorUtil.prototype={

	
// {{{ baseConverter()
    /**
     *	converts numbers from different number systems(example: Decimal to octal)
    *	
     *	@param mixed numberToConvert-Number to convert
     *	@param int oldBase-Convert from which base(8=octal, 10=decimal, 16=hexadecimal)
     *	@param int newBase-Convert to which base(8=octal, 10=decimal, 16=hexadecimal)
     *	
     *	@return String number in new base.(Example: decimal "16" returns "F" when converted to hexadecimal)
     *	@type String
     *
    *@public
     */	
    	
	baseConverter:function(numberToConvert,oldBase,newBase){
	if(newBase==10){
		return parseInt(numberToConvert,16);
	}
	if(newBase==16){
		return parseInt(numberToConvert).toString(16);
	}	
	numberToConvert=numberToConvert+"";
	numberToConvert=numberToConvert.toUpperCase();
	var listOfCharacters="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var dec=0;
	for (var i=0; i <=  numberToConvert.length; i++){
		dec += (listOfCharacters.indexOf(numberToConvert.charAt(i)))* (Math.pow(oldBase , (numberToConvert.length-i-1)));
	}
	numberToConvert="";
	var magnitude=Math.floor((Math.log(dec))/(Math.log(newBase)));
	for (var i=magnitude; i >= 0; i--){
		var amount=Math.floor(dec/Math.pow(newBase,i));
		numberToConvert=numberToConvert+listOfCharacters.charAt(amount); 
		dec -= amount*(Math.pow(newBase,i));
	}
	if(numberToConvert.length==0)numberToConvertToConvert=0;
	if(!numberToConvert)numberToConvert=0;
	return numberToConvert;
	}
	
// }}}
	,
	
// {{{ getHsvByRgbCode()
    /**
     *	Converts a RGB color to HSV
    *	
     *	@param String rgbColor-Example: #FF12AB or FF12AB
     *	@return Array H,S,B=Hue, Saturation and Brightness
     *	@type Array
     *
    *@public
     */	
	getHsvByRgbCode:function(rgbColor){
	rgbColor=rgbColor.replace('#','');	
	red=this.baseConverter(rgbColor.substr(0,2),16,10);
	green=this.baseConverter(rgbColor.substr(2,2),16,10);
	blue=this.baseConverter(rgbColor.substr(4,2),16,10);

	if(red==0&&green==0&&blue==0){
		var returnArray=new Object();
		returnArray.hue=0;
		returnArray.saturation=0;
		returnArray.brightness=0;
		return returnArray;	
	}
		
	red=red/255;
	green=green/255;
	blue=blue/255;
	
	maxValue=Math.max(red,green,blue);
	minValue=Math.min(red,green,blue);
	
	var hue=0;
	
	if(maxValue==minValue){
		hue=0;
		saturation=0;
	}else{
		if(red==maxValue){
		hue=(green-blue)/ (maxValue-minValue)/1;	
		}else if(green==maxValue){
		hue=2+(blue-red)/1 / (maxValue-minValue)/1;	
		}else if(blue==maxValue){
		hue=4+(red-green)/ (maxValue-minValue)/1;	
		}
		saturation=(maxValue-minValue)/ maxValue;
	}
	hue=hue*60; 
	valueBrightness=maxValue;
	
	if(hue<0)hue+=360;	
	var returnArray=new Object();
	returnArray.hue=hue;
	returnArray.saturation=saturation;
	returnArray.brightness=valueBrightness;
	return returnArray;
	}
	
// }}}
	,
	
// {{{ getCompColorByRgb()
    /**
     *	Return the rgb code of a complementary color
    *	
     *	@param String inputRgb-Rgb code
     *
     *	@return String rgbCode-Complementary color
     *	@type String
     *
    *@public
     */	
	getContrastColorByRgb:function(rgbCode)
	{
	var hsv=this.getHsvByRgbCode(rgbCode);	
	hsv.hue+=180;
	if(hsv.hue>=360)hsv.hue-=360;
	return this.getRgbCodeByHsv(hsv.hue,hsv.saturation,hsv.brightness);	
	}
	
// }}}
	,
	
// {{{ getTriadeColorsByRgb()
    /**
     *	Return triade colors of an rgb code. Triade colors are 3 colors located 120 degrees from each other on the color wheel. This method will return the 2 triade colors for the input color
    *	
     *	@param String inputRgb-Rgb code
     *
     *	@return Array colors-Array of triade colors
     *	@type String
     *
    *@public
     */	
	getTriadeColorsByRgb:function(rgbCode)
	{
	var hsv=this.getHsvByRgbCode(rgbCode);	
	var colors=new Array();
	for(var no=120;no<360;no+=120){
		colors[colors.length]=this.getRgbCodeByHsv(hsv.hue+no,hsv.saturation,hsv.brightness)	
	}
	return colors;	
	}
	
// }}}
	,
	
// {{{ getTetradeColorsByRgb()
    /**
     *	Return tetrade colors of an rgb code. Triade colors are 4 colors located 90 degrees from each other on the color wheel. This method will return the 3 tetrade colors for the input color
    *	
     *	@param String inputRgb-Rgb code
     *
     *	@return Array colors-Array of triade colors
     *	@type String
     *
    *@public
     */	
	getTetradeColorsByRgb:function(rgbCode)
	{
	var hsv=this.getHsvByRgbCode(rgbCode);	
	var colors=new Array();
	for(var no=90;no<360;no+=90){
		colors[colors.length]=this.getRgbCodeByHsv(hsv.hue+no,hsv.saturation,hsv.brightness)	
	}
	return colors;	
	}
	
// }}}
	,
	
// {{{ getAnalogicColors()
    /**
     *	Return getAnalogicColors colors of an rgb code. Analogic colors will return 4 colors, two evenly distanced on both sides of the input color. You can specify distance by sending in a second argument to this
     *	method. Default is 25.
    *	
     *	@param String inputRgb-Rgb code
     *	@param Integer degrees-Degrees on the color wheel between colors(value between 15 and 30)
     *
     *	@return Array colors-Array of triade colors
     *	@type String
     *
    *@public
     */	
	getAnalogicColors:function(rgbCode,degrees)
	{
	degrees=degrees+'';
	if(!degrees)degrees=25;
	if(!degrees.match(/^[0-9]{2}$/)){
		degrees=25;
	}
	if(degrees<15)degrees=15;
	if(degrees>30)degrees=30;
	degrees/=1;
	var hsv=this.getHsvByRgbCode(rgbCode);	
	var colors=new Array();
	for(var no=1;no<=2;no++){
		colors[colors.length]=this.getRgbCodeByHsv(hsv.hue+(no*degrees),hsv.saturation,hsv.brightness)	
	}
	for(var no=-1;no>=-2;no--){
		colors[colors.length]=this.getRgbCodeByHsv(hsv.hue+(no*degrees),hsv.saturation,hsv.brightness)	
	}
	return colors;	
	}
	
// }}}
	,
	
// {{{ getRgbCodeByRgbColors()
    /**
     *	Return an rgb code from numeric red,green and blue
    *	
     *	@param Int red-(0-255)
     *	@param int green-( 0-255)
     *	@param int blue-(0-255)
     *
     *	@return Array RGB-Returns an associative array of the keys red,green,blue, example myColor['red'] or myColor.red)
     *	@type String
     *
    *@public
     */	
	getRgbCodeByRgbColors:function(red,green,blue)
	{
	red=this.baseConverter(red,10,16);
	green=this.baseConverter(green,10,16);
	blue=this.baseConverter(blue,10,16);
	
	red=red+"";
	green=green+"";
	blue=blue+"";
	
	while(red.length<2){
		red="0"+red;
	}	
	while(green.length<2){
		green="0"+green;
	}	
	while(blue.length<2){
		blue="0"+""+blue;
	}
	rgbColor=red+""+green+""+blue;
	return rgbColor.toUpperCase();	
	}
	
// }}}
	,
	
// {{{ getRgbColorsByRgbCode()
    /**
     *	Return an rgb code from numeric red,green and blue
    *	
     *	@param String rgbCode in the format RRGGBB ( NO # as prefix)
     *
     *	@return Array RGB-Returns an associative array of the keys red,green,blue, example myColor['red'] or myColor.red)
     *	@type Array
     *
    *@public
     */	
	getRgbColorsByRgbCode:function(rgbCode)
	{
	var retArray=new Object();
	retArray.red=this.baseConverter(rgbCode.substr(0,2),16,10);
	retArray.green=this.baseConverter(rgbCode.substr(2,2),16,10);
	retArray.blue=this.baseConverter(rgbCode.substr(4,2),16,10);
	return retArray;	
	}
	
// }}}	
	,
	
// {{{ getRgbColorsByHsv()
    /**
     *	Return an array of red,green and blue from hue,saturation and brightness
    *	
     *	@param Int hue-Degrees-Position on color wheel. Value between 0 and 359
     *	@param float saturation-Intensity of color(value between 0 and 1)
     *	@param float valueBrightness-Brightness(value between 0 and 1)
     *
     *	@return Array RGB-Returns an associative array of the keys red,green,blue, example myColor['red'] or myColor.red)
     *	@type String
     *
    *@public
     */	
	getRgbColorsByHsv:function(hue,saturation,valueBrightness)
	{
	Hi=Math.floor(hue / 60);
	if(hue==360)hue=0;
	f=hue/60-Hi;
	if(saturation>1)saturation/=100;
	if(valueBrightness>1)valueBrightness/=100;
	
	p=(valueBrightness*(1- saturation));
	q=(valueBrightness*(1-(f*saturation)));
	t=(valueBrightness*(1-((1-f)*saturation)));

	switch(Hi){
		case 0:
		red=valueBrightness;
		green=t;
		blue=p;		
		break;
		case 1: 
		red=q;
		green=valueBrightness;
		blue=p;
		break;
		case 2: 
		red=p;
		green=valueBrightness;
		blue=t;
		break;
		case 3: 
		red=p;
		green=q;;
		blue=valueBrightness;
		break;
		case 4:
		red=t;
		green=p;
		blue=valueBrightness;
		break;
		default:
		red=valueBrightness;
		green=p;
		blue=q;
		break;
	}
	
	if(saturation==0){
		red=valueBrightness;
		green=valueBrightness;
		blue=valueBrightness;	
	}
	
	red*=255;
	green*=255;
	blue*=255;
	
	red=Math.round(red);
	green=Math.round(green);
	blue=Math.round(blue);	
		
	var retArray=new Object();
	retArray.red=red;
	retArray.green=green;
	retArray.blue=blue;
	return retArray;	
	}
	
// }}}
	,
	
// {{{ getRgbCodeByHsv()
    /**
     *	Converts a RGB color to HSV
    *	
     *	@param Int hue-Degrees-Position on color wheel. Value between 0 and 359
     *	@param float saturation-Intensity of color(value between 0 and 1)
     *	@param float valueBrightness-Brightness(value between 0 and 1)
     *
     *	@return String RGBColor-example #FF00FF
     *	@type String
     *
    *@public
     */	
	getRgbCodeByHsv:function(hue,saturation,valueBrightness){
	while(hue>=360)hue-=360;
	var colors=this.getRgbColorsByHsv(hue,saturation,valueBrightness);	
	var red=colors.red;
	var green=colors.green
	var blue=colors.blue;
	
	return this.getRgbCodeByRgbColors(red,green,blue);
	}
	
// }}}	
	,
	
// {{{ getColorByDegrees()
    /**
     *	Returns RGB color from a position on the color wheel
    *	
     *	@param String rgbColor-Rgb color to calculate degrees from
     *	@param Float degrees-How many degrees to move on the color wheel(clockwise)
     *
     *	@return String RGBColor-new rgb color-example #FF00FF
     *	@type String
     *
    *@public
     */	
	getColorByDegrees:function(rgbColor,degrees){
	rgbColor=rgbColor.replace('#','');
	myArray=this.getHsvByRgbCode(rgbColor);
	myArray.hue+=degrees;
	if(myArray.hue>=360)myArray.hue-=360;
	if(myArray.hue<0)myArray.hue+=360;	
	return this.getRgbCodeByHsv(myArray.hue,myArray.saturation,myArray.brightness);
	}
	
// }}}	
	,
	
// {{{ findColorByBrightness()
    /**
     *	Returns a new rgb color after change of brightness
    *	
     *	@param String rgbColor-RGB start color
     *	@param Int brightness-Change in brightness (value between -100 and 100)
     *
     *	@return String RGBColor-new rgb color-example #FF00FF
     *	@type String
     *
    *@public
     */	
	findColorByBrightness:function(rgbColor,brightness){
	
	rgbColor=rgbColor.replace('#','');
	myArray=this.getHsvByRgbCode(rgbColor);
	
	myArray.brightness+=brightness/100;
	if(myArray.brightness>1)myArray.brightness=1;
	if(myArray.brightness<0)myArray.brightness=0;	
	
	if(myArray.saturation>1)myArray.saturation=1;
	if(myArray.saturation<0)myArray.saturation=0;	
	
	return this.getRgbCodeByHsv(myArray.hue,myArray.saturation,myArray.brightness);		
	}
	
// }}}
	,
	
// {{{ getRgbFromNumbers()
    /**
     *	Returns a color in RGB format(e.g.: #FFEECC from numeric values of red, green and blue)
    *	
     *	@param Int red-Amount of red(0-255)
     *	@param Int green-Amount of green(0-255)
     *	@param Int blue-Amount of blue(0-255)
	 *
     *
     *	@return String RGBColor-new rgb color-example #FF00FF
     *	@type String
     *
    *@public
     */	
	getRgbFromNumbers:function(red,green,blue)
	{
	red=this.baseConverter(red,10,16);
	if(red.length==0)red='0'+red;
	green=this.baseConverter(green,10,16);
	if(green.length==0)green='0'+green;
	blue=this.baseConverter(blue,10,16);
	if(blue.length==0)blue='0'+blue;
	return '#'+red+green+blue;
	}   
	
// }}}
	,
	
// {{{ getAllWebColors()
    /**
     *	This method returns an array of all web colors
    *	
	 *
     *
     *	@return Array RGBColors-Numeric array of all web colors (216 colors)
     *	@type String
     *
    *@public
     */	
	getAllWebColors:function()
	{
	var retArray=new Array();
	for(var red=0;red<=15;red+=3){
		for(var green=0;green<=15;green+=3){
		for(var blue=0;blue<=15;blue+=3){
			var newRed=this.baseConverter(red,10,16);		
			var newGreen=this.baseConverter(green,10,16);		
			var newBlue=this.baseConverter(blue,10,16);	
			retArray[retArray.length]=newRed+''+newRed+'' +newGreen +''+newGreen +''+newBlue+''+newBlue;	
		}
		}
	}
	return retArray;	
	}
	
// }}}
	,
	
// {{{ getAllNamedColors()
    /**
     *	This method returns an array of all web colors
    *	
	 *
     *
     *	@return Array Colors-Returns a multi dimensional array of colors, first index separate each color. Each item in the main array will then contain two values: 1)color name, 2)rgb code 
     *	@type Array
     *
    *@public
     */	
	getAllNamedColors:function()
	{
	var c=new Array();
	c[c.length]=['AliceBlue','F0F8FF'];
	c[c.length]=['AntiqueWhite','FAEBD7'];
	c[c.length]=['Aqua','00FFFF'];
	c[c.length]=['Aquamarine','7FFFD4'];
	c[c.length]=['Azure','F0FFFF'];
	c[c.length]=['Beige','F5F5DC'];
	c[c.length]=['Bisque','FFE4C4'];
	c[c.length]=['Black','000000'];
	c[c.length]=['BlanchedAlmond','FFEBCD'];
	c[c.length]=['Blue','0000FF'];
	c[c.length]=['BlueViolet','8A2BE2'];
	c[c.length]=['Brown','A52A2A'];
	c[c.length]=['BurlyWood','DEB887'];
	c[c.length]=['CadetBlue','5F9EA0'];
	c[c.length]=['Chartreuse','7FFF00'];
	c[c.length]=['Chocolate','D2691E'];
	c[c.length]=['Coral','FF7F50'];
	c[c.length]=['CornflowerBlue','6495ED'];
	c[c.length]=['Cornsilk','FFF8DC'];
	c[c.length]=['Crimson','DC143C'];
	c[c.length]=['Cyan','00FFFF'];
	c[c.length]=['DarkBlue','00008B'];
	c[c.length]=['DarkCyan','008B8B'];
	c[c.length]=['DarkGoldenRod','B8860B'];
	c[c.length]=['DarkGray','A9A9A9'];
	c[c.length]=['DarkGrey','A9A9A9'];
	c[c.length]=['DarkGreen','006400'];
	c[c.length]=['DarkKhaki','BDB76B'];
	c[c.length]=['DarkMagenta','8B008B'];
	c[c.length]=['DarkOliveGreen','556B2F'];
	c[c.length]=['Darkorange','FF8C00'];
	c[c.length]=['DarkOrchid','9932CC'];
	c[c.length]=['DarkRed','8B0000'];
	c[c.length]=['DarkSalmon','E9967A'];
	c[c.length]=['DarkSeaGreen','8FBC8F'];
	c[c.length]=['DarkSlateBlue','483D8B'];
	c[c.length]=['DarkSlateGray','2F4F4F'];
	c[c.length]=['DarkSlateGrey','2F4F4F'];
	c[c.length]=['DarkTurquoise','00CED1'];
	c[c.length]=['DarkViolet','9400D3'];
	c[c.length]=['DeepPink','FF1493'];
	c[c.length]=['DeepSkyBlue','00BFFF'];
	c[c.length]=['DimGray','696969'];
	c[c.length]=['DimGrey','696969'];
	c[c.length]=['DodgerBlue','1E90FF'];
	c[c.length]=['FireBrick','B22222'];
	c[c.length]=['FloralWhite','FFFAF0'];
	c[c.length]=['ForestGreen','228B22'];
	c[c.length]=['Fuchsia','FF00FF'];
	c[c.length]=['Gainsboro','DCDCDC'];
	c[c.length]=['GhostWhite','F8F8FF'];
	c[c.length]=['Gold','FFD700'];
	c[c.length]=['GoldenRod','DAA520'];
	c[c.length]=['Gray','808080'];
	c[c.length]=['Grey','808080'];
	c[c.length]=['Green','008000'];
	c[c.length]=['GreenYellow','ADFF2F'];
	c[c.length]=['HoneyDew','F0FFF0'];
	c[c.length]=['HotPink','FF69B4'];
	c[c.length]=['IndianRed ','CD5C5C'];
	c[c.length]=['Indigo  ','4B0082'];
	c[c.length]=['Ivory','FFFFF0'];
	c[c.length]=['Khaki','F0E68C'];
	c[c.length]=['Lavender','E6E6FA'];
	c[c.length]=['LavenderBlush','FFF0F5'];
	c[c.length]=['LawnGreen','7CFC00'];
	c[c.length]=['LemonChiffon','FFFACD'];
	c[c.length]=['LightBlue','ADD8E6'];
	c[c.length]=['LightCoral','F08080'];
	c[c.length]=['LightCyan','E0FFFF'];
	c[c.length]=['LightGoldenRodYellow','FAFAD2'];
	c[c.length]=['LightGray','D3D3D3'];
	c[c.length]=['LightGrey','D3D3D3'];
	c[c.length]=['LightGreen','90EE90'];
	c[c.length]=['LightPink','FFB6C1'];
	c[c.length]=['LightSalmon','FFA07A'];
	c[c.length]=['LightSeaGreen','20B2AA'];
	c[c.length]=['LightSkyBlue','87CEFA'];
	c[c.length]=['LightSlateGray','778899'];
	c[c.length]=['LightSlateGrey','778899'];
	c[c.length]=['LightSteelBlue','B0C4DE'];
	c[c.length]=['LightYellow','FFFFE0'];
	c[c.length]=['Lime','00FF00'];
	c[c.length]=['LimeGreen','32CD32'];
	c[c.length]=['Linen','FAF0E6'];
	c[c.length]=['Magenta','FF00FF'];
	c[c.length]=['Maroon','800000'];
	c[c.length]=['MediumAquaMarine','66CDAA'];
	c[c.length]=['MediumBlue','0000CD'];
	c[c.length]=['MediumOrchid','BA55D3'];
	c[c.length]=['MediumPurple','9370D8'];
	c[c.length]=['MediumSeaGreen','3CB371'];
	c[c.length]=['MediumSlateBlue','7B68EE'];
	c[c.length]=['MediumSpringGreen','00FA9A'];
	c[c.length]=['MediumTurquoise','48D1CC'];
	c[c.length]=['MediumVioletRed','C71585'];
	c[c.length]=['MidnightBlue','191970'];
	c[c.length]=['MintCream','F5FFFA'];
	c[c.length]=['MistyRose','FFE4E1'];
	c[c.length]=['Moccasin','FFE4B5'];
	c[c.length]=['NavajoWhite','FFDEAD'];
	c[c.length]=['Navy','000080'];
	c[c.length]=['OldLace','FDF5E6'];
	c[c.length]=['Olive','808000'];
	c[c.length]=['OliveDrab','6B8E23'];
	c[c.length]=['Orange','FFA500'];
	c[c.length]=['OrangeRed','FF4500'];
	c[c.length]=['Orchid','DA70D6'];
	c[c.length]=['PaleGoldenRod','EEE8AA'];
	c[c.length]=['PaleGreen','98FB98'];
	c[c.length]=['PaleTurquoise','AFEEEE'];
	c[c.length]=['PaleVioletRed','D87093'];
	c[c.length]=['PapayaWhip','FFEFD5'];
	c[c.length]=['PeachPuff','FFDAB9'];
	c[c.length]=['Peru','CD853F'];
	c[c.length]=['Pink','FFC0CB'];
	c[c.length]=['Plum','DDA0DD'];
	c[c.length]=['PowderBlue','B0E0E6'];
	c[c.length]=['Purple','800080'];
	c[c.length]=['Red','FF0000'];
	c[c.length]=['RosyBrown','BC8F8F'];
	c[c.length]=['RoyalBlue','4169E1'];
	c[c.length]=['SaddleBrown','8B4513'];
	c[c.length]=['Salmon','FA8072'];
	c[c.length]=['SandyBrown','F4A460'];
	c[c.length]=['SeaGreen','2E8B57'];
	c[c.length]=['SeaShell','FFF5EE'];
	c[c.length]=['Sienna','A0522D'];
	c[c.length]=['Silver','C0C0C0'];
	c[c.length]=['SkyBlue','87CEEB'];
	c[c.length]=['SlateBlue','6A5ACD'];
	c[c.length]=['SlateGray','708090'];
	c[c.length]=['SlateGrey','708090'];
	c[c.length]=['Snow','FFFAFA'];
	c[c.length]=['SpringGreen','00FF7F'];
	c[c.length]=['SteelBlue','4682B4'];
	c[c.length]=['Tan','D2B48C'];
	c[c.length]=['Teal','008080'];
	c[c.length]=['Thistle','D8BFD8'];
	c[c.length]=['Tomato','FF6347'];
	c[c.length]=['Turquoise','40E0D0'];
	c[c.length]=['Violet','EE82EE'];
	c[c.length]=['Wheat','F5DEB3'];
	c[c.length]=['White','FFFFFF'];
	c[c.length]=['WhiteSmoke','F5F5F5'];
	c[c.length]=['Yellow','FFFF00'];
	c[c.length]=['YellowGreen','9ACD32'];
	return c;	
	}	
}
