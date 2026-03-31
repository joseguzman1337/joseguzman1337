// ** I18N

// Calendar EN language
// Author: Mihai Bazon, <mihai_bazon@yahoo.com>
// Translation: Yourim Yi <yyi@yourim.net>
// Encoding: EUC-KR
// lang : ko
// Distributed under the same terms as the calendar itself.

// For translators: please use UTF-8 if possible.  We strongly believe that
// Unicode is the answer to a real internationalized world.  Also please
// include your contact information in the header, as can be seen above.

// full day names

Calendar._DN = new Array
("ì¼ìì¼",
 "ììì¼",
 "íìì¼",
 "ììì¼",
 "ëª©ìì¼",
 "ê¸ìì¼",
 "í ìì¼",
 "ì¼ìì¼");

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
("ì¼",
 "ì",
 "í",
 "ì",
 "ëª©",
 "ê¸",
 "í ",
 "ì¼");

// full month names
Calendar._MN = new Array
("1ì",
 "2ì",
 "3ì",
 "4ì",
 "5ì",
 "6ì",
 "7ì",
 "8ì",
 "9ì",
 "10ì",
 "11ì",
 "12ì");

// short month names
Calendar._SMN = new Array
("1",
 "2",
 "3",
 "4",
 "5",
 "6",
 "7",
 "8",
 "9",
 "10",
 "11",
 "12");

// tooltips
Calendar._TT = {};
Calendar._TT["INFO"] = "calendar ì ëí´ì";

Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) dynarch.com 2002-2005 / Author: Mihai Bazon\n" + // don't translate this this ;-)
"\n"+
"ìµì  ë²ì ì ë°ì¼ìë ¤ë©´ http://www.dynarch.com/projects/calendar/ ì ë°©ë¬¸íì¸ì\n" +
"\n"+
"GNU LGPL ë¼ì´ì¼ì¤ë¡ ë°°í¬ë©ëë¤. \n"+
"ë¼ì´ì¼ì¤ì ëí ìì¸í ë´ì©ì http://gnu.org/licenses/lgpl.html ì ì½ì¼ì¸ì." +
"\n\n" +
"ë ì§ ì í:\n" +
"- ì°ëë¥¼ ì ííë ¤ë©´ \xab, \xbb ë²í¼ì ì¬ì©í©ëë¤\n" +
"- ë¬ì ì ííë ¤ë©´ " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " ë²í¼ì ëë¥´ì¸ì\n" +
"- ê³ì ëë¥´ê³  ìì¼ë©´ ì ê°ë¤ì ë¹ ë¥´ê² ì ííì¤ ì ììµëë¤.";
Calendar._TT["ABOUT_TIME"] = "\n\n" +
"ìê° ì í:\n" +
"- ë§ì°ì¤ë¡ ëë¥´ë©´ ìê°ì´ ì¦ê°í©ëë¤\n" +
"- Shift í¤ì í¨ê» ëë¥´ë©´ ê°ìí©ëë¤\n" +
"- ëë¥¸ ìíìì ë§ì°ì¤ë¥¼ ìì§ì´ë©´ ì¢ ë ë¹ ë¥´ê² ê°ì´ ë³í©ëë¤.\n";

Calendar._TT["PREV_YEAR"] = "ì§ë í´ (ê¸¸ê² ëë¥´ë©´ ëª©ë¡)";
Calendar._TT["PREV_MONTH"] = "ì§ë ë¬ (ê¸¸ê² ëë¥´ë©´ ëª©ë¡)";
Calendar._TT["GO_TODAY"] = "ì¤ë ë ì§ë¡";
Calendar._TT["NEXT_MONTH"] = "ë¤ì ë¬ (ê¸¸ê² ëë¥´ë©´ ëª©ë¡)";
Calendar._TT["NEXT_YEAR"] = "ë¤ì í´ (ê¸¸ê² ëë¥´ë©´ ëª©ë¡)";
Calendar._TT["SEL_DATE"] = "ë ì§ë¥¼ ì ííì¸ì";
Calendar._TT["DRAG_TO_MOVE"] = "ë§ì°ì¤ ëëê·¸ë¡ ì´ë íì¸ì";
Calendar._TT["PART_TODAY"] = " (ì¤ë)";
Calendar._TT["MON_FIRST"] = "ììì¼ì í ì£¼ì ìì ìì¼ë¡";
Calendar._TT["SUN_FIRST"] = "ì¼ìì¼ì í ì£¼ì ìì ìì¼ë¡";
Calendar._TT["CLOSE"] = "ë«ê¸°";
Calendar._TT["TODAY"] = "ì¤ë";
Calendar._TT["TIME_PART"] = "(Shift-)í´ë¦­ ëë ëëê·¸ íì¸ì";

// date formats
Calendar._TT["DEF_DATE_FORMAT"] = "%Y-%m-%d";
Calendar._TT["TT_DATE_FORMAT"] = "%b/%e [%a]";

Calendar._TT["WK"] = "ì£¼";
