ï»¿// ** I18N

// Calendar PL language
// Author: Dariusz Pietrzak, <eyck@ghost.anime.pl>
// Author: Janusz Piwowarski, <jpiw@go2.pl>
// Encoding: utf-8
// Distributed under the same terms as the calendar itself.

Calendar._DN = new Array
("Niedziela",
 "PoniedziaÅek",
 "Wtorek",
 "Åroda",
 "Czwartek",
 "PiÄtek",
 "Sobota",
 "Niedziela");
Calendar._SDN = new Array
("Nie",
 "Pn",
 "Wt",
 "År",
 "Cz",
 "Pt",
 "So",
 "Nie");
Calendar._MN = new Array
("StyczeÅ",
 "Luty",
 "Marzec",
 "KwiecieÅ",
 "Maj",
 "Czerwiec",
 "Lipiec",
 "SierpieÅ",
 "WrzesieÅ",
 "PaÅºdziernik",
 "Listopad",
 "GrudzieÅ");
Calendar._SMN = new Array
("Sty",
 "Lut",
 "Mar",
 "Kwi",
 "Maj",
 "Cze",
 "Lip",
 "Sie",
 "Wrz",
 "PaÅº",
 "Lis",
 "Gru");

// tooltips
Calendar._TT = {};
Calendar._TT["INFO"] = "O kalendarzu";

Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) dynarch.com 2002-2005 / Author: Mihai Bazon\n" + // don't translate this this ;-)
"Aby pobraÄ najnowszÄ wersjÄ, odwiedÅº: http://www.dynarch.com/projects/calendar/\n" +
"DostÄpny na licencji GNU LGPL. Zobacz szczegÃ³Åy na http://gnu.org/licenses/lgpl.html." +
"\n\n" +
"WybÃ³r daty:\n" +
"- UÅ¼yj przyciskÃ³w \xab, \xbb by wybraÄ rok\n" +
"- UÅ¼yj przyciskÃ³w " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " by wybraÄ miesiÄc\n" +
"- Przytrzymaj klawisz myszy nad jednym z powyÅ¼szych przyciskÃ³w dla szybszego wyboru.";
Calendar._TT["ABOUT_TIME"] = "\n\n" +
"WybÃ³r czasu:\n" +
"- Kliknij na jednym z pÃ³l czasu by zwiÄkszyÄ jego wartoÅÄ\n" +
"- lub kliknij trzymajÄc Shift by zmiejszyÄ jego wartoÅÄ\n" +
"- lub kliknij i przeciÄgnij dla szybszego wyboru.";

//Calendar._TT["TOGGLE"] = "ZmieÅ pierwszy dzieÅ tygodnia";
Calendar._TT["PREV_YEAR"] = "Poprzedni rok (przytrzymaj dla menu)";
Calendar._TT["PREV_MONTH"] = "Poprzedni miesiÄc (przytrzymaj dla menu)";
Calendar._TT["GO_TODAY"] = "IdÅº do dzisiaj";
Calendar._TT["NEXT_MONTH"] = "NastÄpny miesiÄc (przytrzymaj dla menu)";
Calendar._TT["NEXT_YEAR"] = "NastÄpny rok (przytrzymaj dla menu)";
Calendar._TT["SEL_DATE"] = "Wybierz datÄ";
Calendar._TT["DRAG_TO_MOVE"] = "PrzeciÄgnij by przesunÄÄ";
Calendar._TT["PART_TODAY"] = " (dzisiaj)";
Calendar._TT["MON_FIRST"] = "WyÅwietl poniedziaÅek jako pierwszy";
Calendar._TT["SUN_FIRST"] = "WyÅwietl niedzielÄ jako pierwszÄ";
Calendar._TT["CLOSE"] = "Zamknij";
Calendar._TT["TODAY"] = "Dzisiaj";
Calendar._TT["TIME_PART"] = "(Shift-)Kliknij lub przeciÄgnij by zmieniÄ wartoÅÄ";

// date formats
Calendar._TT["DEF_DATE_FORMAT"] = "%Y-%m-%d";
Calendar._TT["TT_DATE_FORMAT"] = "%e %B, %A";

Calendar._TT["WK"] = "ty";
