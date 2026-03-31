// ** I18N

// Calendar big5-utf8 language
// Author: Gary Fu, <gary@garyfu.idv.tw>
// Encoding: utf8
// Distributed under the same terms as the calendar itself.

// For translators: please use UTF-8 if possible.  We strongly believe that
// Unicode is the answer to a real internationalized world.  Also please
// include your contact information in the header, as can be seen above.
	
// full day names
Calendar._DN = new Array
("æææ¥",
 "ææä¸",
 "ææäº",
 "ææä¸",
 "ææå",
 "ææäº",
 "ææå­",
 "æææ¥");

// Please note that the following array of short day names (and the same goes
// for short month names, _SMN) isn't absolutely necessary.  We give it here
// for exemplification on how one can customize the short day names, but if
// they are simply the first N letters of the full name you can simply say:
//
//   Calendar._SDN_len = N; // short day name length
//   Calendar._SMN_len = N; // short month name length
//
// If N = 3 then this is not needed either since we assume a value of 3 if not
// present, to be compatible with translation files that were written before
// this feature.

// short day names
Calendar._SDN = new Array
("æ¥",
 "ä¸",
 "äº",
 "ä¸",
 "å",
 "äº",
 "å­",
 "æ¥");

// full month names
Calendar._MN = new Array
("ä¸æ",
 "äºæ",
 "ä¸æ",
 "åæ",
 "äºæ",
 "å­æ",
 "ä¸æ",
 "å«æ",
 "ä¹æ",
 "åæ",
 "åä¸æ",
 "åäºæ");

// short month names
Calendar._SMN = new Array
("ä¸æ",
 "äºæ",
 "ä¸æ",
 "åæ",
 "äºæ",
 "å­æ",
 "ä¸æ",
 "å«æ",
 "ä¹æ",
 "åæ",
 "åä¸æ",
 "åäºæ");

// tooltips
Calendar._TT = {};
Calendar._TT["INFO"] = "éæ¼";

Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) dynarch.com 2002-2005 / Author: Mihai Bazon\n" + // don't translate this this ;-)
"For latest version visit: http://www.dynarch.com/projects/calendar/\n" +
"Distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"æ¥æé¸ææ¹æ³:\n" +
"- ä½¿ç¨ \xab, \xbb æéå¯é¸æå¹´ä»½\n" +
"- ä½¿ç¨ " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " æéå¯é¸ææä»½\n" +
"- æä½ä¸é¢çæéå¯ä»¥å å¿«é¸å";
Calendar._TT["ABOUT_TIME"] = "\n\n" +
"æéé¸ææ¹æ³:\n" +
"- é»æä»»ä½çæéé¨ä»½å¯å¢å å¶å¼\n" +
"- åææShiftéµåé»æå¯æ¸å°å¶å¼\n" +
"- é»æä¸¦ææ³å¯å å¿«æ¹è®çå¼";

Calendar._TT["PREV_YEAR"] = "ä¸ä¸å¹´ (æä½é¸å®)";
Calendar._TT["PREV_MONTH"] = "ä¸ä¸å¹´ (æä½é¸å®)";
Calendar._TT["GO_TODAY"] = "å°ä»æ¥";
Calendar._TT["NEXT_MONTH"] = "ä¸ä¸æ (æä½é¸å®)";
Calendar._TT["NEXT_YEAR"] = "ä¸ä¸æ (æä½é¸å®)";
Calendar._TT["SEL_DATE"] = "é¸ææ¥æ";
Calendar._TT["DRAG_TO_MOVE"] = "ææ³";
Calendar._TT["PART_TODAY"] = " (ä»æ¥)";

// the following is to inform that "%s" is to be the first day of week
// %s will be replaced with the day name.
Calendar._TT["DAY_FIRST"] = "å° %s é¡¯ç¤ºå¨å";

// This may be locale-dependent.  It specifies the week-end days, as an array
// of comma-separated numbers.  The numbers are from 0 to 6: 0 means Sunday, 1
// means Monday, etc.
Calendar._TT["WEEKEND"] = "0,6";

Calendar._TT["CLOSE"] = "éé";
Calendar._TT["TODAY"] = "ä»æ¥";
Calendar._TT["TIME_PART"] = "é»æorææ³å¯æ¹è®æé(åææShiftçºæ¸)";

// date formats
Calendar._TT["DEF_DATE_FORMAT"] = "%Y-%m-%d";
Calendar._TT["TT_DATE_FORMAT"] = "%a, %b %e";

Calendar._TT["WK"] = "é±";
Calendar._TT["TIME"] = "Time:";
