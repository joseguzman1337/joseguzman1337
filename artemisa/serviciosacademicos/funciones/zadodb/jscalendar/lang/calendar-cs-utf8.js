/* 
	calendar-cs-win.js
	language: Czech
	encoding: windows-1250
	author: Lubos Jerabek (xnet@seznam.cz)
	        Jan Uhlir (espinosa@centrum.cz)
*/

// ** I18N
Calendar._DN  = new Array('NedÄle','PondÄlÃ­','ÃterÃ½','StÅeda','Ätvrtek','PÃ¡tek','Sobota','NedÄle');
Calendar._SDN = new Array('Ne','Po','Ãt','St','Ät','PÃ¡','So','Ne');
Calendar._MN  = new Array('Leden','Ãnor','BÅezen','Duben','KvÄten','Äerven','Äervenec','Srpen','ZÃ¡ÅÃ­','ÅÃ­jen','Listopad','Prosinec');
Calendar._SMN = new Array('Led','Ãno','BÅe','Dub','KvÄ','Ärv','Ävc','Srp','ZÃ¡Å','ÅÃ­j','Lis','Pro');

// tooltips
Calendar._TT = {};
Calendar._TT["INFO"] = "O komponentÄ kalendÃ¡Å";
Calendar._TT["TOGGLE"] = "ZmÄna prvnÃ­ho dne v tÃ½dnu";
Calendar._TT["PREV_YEAR"] = "PÅedchozÃ­ rok (pÅidrÅ¾ pro menu)";
Calendar._TT["PREV_MONTH"] = "PÅedchozÃ­ mÄsÃ­c (pÅidrÅ¾ pro menu)";
Calendar._TT["GO_TODAY"] = "DneÅ¡nÃ­ datum";
Calendar._TT["NEXT_MONTH"] = "DalÅ¡Ã­ mÄsÃ­c (pÅidrÅ¾ pro menu)";
Calendar._TT["NEXT_YEAR"] = "DalÅ¡Ã­ rok (pÅidrÅ¾ pro menu)";
Calendar._TT["SEL_DATE"] = "Vyber datum";
Calendar._TT["DRAG_TO_MOVE"] = "ChyÅ¥ a tÃ¡hni, pro pÅesun";
Calendar._TT["PART_TODAY"] = " (dnes)";
Calendar._TT["MON_FIRST"] = "UkaÅ¾ jako prvnÃ­ PondÄlÃ­";
//Calendar._TT["SUN_FIRST"] = "UkaÅ¾ jako prvnÃ­ NedÄli";

Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) dynarch.com 2002-2005 / Author: Mihai Bazon\n" + // don't translate this this ;-)
"For latest version visit: http://www.dynarch.com/projects/calendar/\n" +
"Distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"VÃ½bÄr datumu:\n" +
"- Use the \xab, \xbb buttons to select year\n" +
"- PouÅ¾ijte tlaÄÃ­tka " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " k vÃ½bÄru mÄsÃ­ce\n" +
"- PodrÅ¾te tlaÄÃ­tko myÅ¡i na jakÃ©mkoliv z tÄch tlaÄÃ­tek pro rychlejÅ¡Ã­ vÃ½bÄr.";

Calendar._TT["ABOUT_TIME"] = "\n\n" +
"VÃ½bÄr Äasu:\n" +
"- KliknÄte na jakoukoliv z ÄÃ¡stÃ­ vÃ½bÄru Äasu pro zvÃ½Å¡enÃ­.\n" +
"- nebo Shift-click pro snÃ­Å¾enÃ­\n" +
"- nebo kliknÄte a tÃ¡hnÄte pro rychlejÅ¡Ã­ vÃ½bÄr.";

// the following is to inform that "%s" is to be the first day of week
// %s will be replaced with the day name.
Calendar._TT["DAY_FIRST"] = "Zobraz %s prvnÃ­";

// This may be locale-dependent.  It specifies the week-end days, as an array
// of comma-separated numbers.  The numbers are from 0 to 6: 0 means Sunday, 1
// means Monday, etc.
Calendar._TT["WEEKEND"] = "0,6";

Calendar._TT["CLOSE"] = "ZavÅÃ­t";
Calendar._TT["TODAY"] = "Dnes";
Calendar._TT["TIME_PART"] = "(Shift-)Klikni nebo tÃ¡hni pro zmÄnu hodnoty";

// date formats
Calendar._TT["DEF_DATE_FORMAT"] = "d.m.yy";
Calendar._TT["TT_DATE_FORMAT"] = "%a, %b %e";

Calendar._TT["WK"] = "wk";
Calendar._TT["TIME"] = "Äas:";
