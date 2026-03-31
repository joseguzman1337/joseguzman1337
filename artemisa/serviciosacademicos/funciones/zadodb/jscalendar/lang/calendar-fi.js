ï»¿// ** I18N

// Calendar FI language (Finnish, Suomi)
// Author: Jarno KÃ¤yhkÃ¶, <gambler@phnet.fi>
// Encoding: UTF-8
// Distributed under the same terms as the calendar itself.

// full day names
Calendar._DN = new Array
("Sunnuntai",
 "Maanantai",
 "Tiistai",
 "Keskiviikko",
 "Torstai",
 "Perjantai",
 "Lauantai",
 "Sunnuntai");

// short day names
Calendar._SDN = new Array
("Su",
 "Ma",
 "Ti",
 "Ke",
 "To",
 "Pe",
 "La",
 "Su");

// full month names
Calendar._MN = new Array
("Tammikuu",
 "Helmikuu",
 "Maaliskuu",
 "Huhtikuu",
 "Toukokuu",
 "KesÃ¤kuu",
 "HeinÃ¤kuu",
 "Elokuu",
 "Syyskuu",
 "Lokakuu",
 "Marraskuu",
 "Joulukuu");

// short month names
Calendar._SMN = new Array
("Tam",
 "Hel",
 "Maa",
 "Huh",
 "Tou",
 "Kes",
 "Hei",
 "Elo",
 "Syy",
 "Lok",
 "Mar",
 "Jou");

// tooltips
Calendar._TT = {};
Calendar._TT["INFO"] = "Tietoja kalenterista";

Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) dynarch.com 2002-2005 / Author: Mihai Bazon\n" + // don't translate this this ;-)
"Uusin versio osoitteessa: http://www.dynarch.com/projects/calendar/\n" +
"Julkaistu GNU LGPL lisenssin alaisuudessa. LisÃ¤tietoja osoitteessa http://gnu.org/licenses/lgpl.html" +
"\n\n" +
"PÃ¤ivÃ¤mÃ¤Ã¤rÃ¤ valinta:\n" +
"- KÃ¤ytÃ¤ \xab, \xbb painikkeita valitaksesi vuosi\n" +
"- KÃ¤ytÃ¤ " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " painikkeita valitaksesi kuukausi\n" +
"- PitÃ¤mÃ¤llÃ¤ hiiren painiketta minkÃ¤ tahansa yllÃ¤ olevan painikkeen kohdalla, saat nÃ¤kyviin valikon nopeampaan siirtymiseen.";
Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Ajan valinta:\n" +
"- Klikkaa kellonajan numeroita lisÃ¤tÃ¤ksesi aikaa\n" +
"- tai pitÃ¤mÃ¤llÃ¤ Shift-nÃ¤ppÃ¤intÃ¤ pohjassa saat aikaa taaksepÃ¤in\n" +
"- tai klikkaa ja pidÃ¤ hiiren painike pohjassa sekÃ¤ liikuta hiirtÃ¤ muuttaaksesi aikaa nopeasti eteen- ja taaksepÃ¤in.";

Calendar._TT["PREV_YEAR"] = "Edell. vuosi (paina hetki, nÃ¤et valikon)";
Calendar._TT["PREV_MONTH"] = "Edell. kuukausi (paina hetki, nÃ¤et valikon)";
Calendar._TT["GO_TODAY"] = "Siirry tÃ¤hÃ¤n pÃ¤ivÃ¤Ã¤n";
Calendar._TT["NEXT_MONTH"] = "Seur. kuukausi (paina hetki, nÃ¤et valikon)";
Calendar._TT["NEXT_YEAR"] = "Seur. vuosi (paina hetki, nÃ¤et valikon)";
Calendar._TT["SEL_DATE"] = "Valitse pÃ¤ivÃ¤mÃ¤Ã¤rÃ¤";
Calendar._TT["DRAG_TO_MOVE"] = "SiirrÃ¤ kalenterin paikkaa";
Calendar._TT["PART_TODAY"] = " (tÃ¤nÃ¤Ã¤n)";
Calendar._TT["MON_FIRST"] = "NÃ¤ytÃ¤ maanantai ensimmÃ¤isenÃ¤";
Calendar._TT["SUN_FIRST"] = "NÃ¤ytÃ¤ sunnuntai ensimmÃ¤isenÃ¤";
Calendar._TT["CLOSE"] = "Sulje";
Calendar._TT["TODAY"] = "TÃ¤nÃ¤Ã¤n";
Calendar._TT["TIME_PART"] = "(Shift-) Klikkaa tai liikuta muuttaaksesi aikaa";

// date formats
Calendar._TT["DEF_DATE_FORMAT"] = "%d.%m.%Y";
Calendar._TT["TT_DATE_FORMAT"] = "%d.%m.%Y";

Calendar._TT["WK"] = "Vko";
