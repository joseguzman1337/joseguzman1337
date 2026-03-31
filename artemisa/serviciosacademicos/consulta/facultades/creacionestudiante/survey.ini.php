;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
; UCCASS CONFIGURATION FILE ;
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
;
; Unit Command Climate Assessment and
; Survey System
;
;
; <?php exit(); ?>
; Do not remove the above line. This line will
; prevent this file from being read if called
; through a web server
;
; Edit the following lines to
; match your configuration
;
; Any non-alphanumeric values must
; be enclosed in double quotes unless
; the values are being entered through
; the web interface
; OK: variable = 1
; OK: variable = word
; BAD: variable = this&that or a space
; BAD: variable = 'this&that'
; OK: variable = "this&that"
;
;;;;;;;;;;;;;;;;;
; Path Examples ;
;;;;;;;;;;;;;;;;;
; Windows: c:\\path\\to\\directory
; Windows: c:/path/to/directory
; Windows: /path/to/directory (if on C: drive)
; *nix: /path/to/dir

;;;;;;;;;;;;;;
; SITE SETUP ;
;;;;;;;;;;;;;;

; File Path to UCCASS files
; ex: /home/user/name/public_html/uccass
path = "/usr/local/apache2/htdocs/html/serviciosacademicos/consulta/facultades/creacionestudiante"

; HTML Path to UCCASS installation
; ex: https://www.youdomain.com/subdir/uccass
html = "https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/creacionestudiante"

; Site Name
;
; Will appear in Title Bar and Main Page
site_name = "Sistema  de Encuestas"

; Default Template
;
; Default template to use for the
; main site and surveys. This must
; match the name of a Directory in
; the templates/ folder.
default_template = Default

; Page Break Text
;
; This is the text the users will enter
; into the text box to create a page
; break in their surveys. The text is
; case insensitive.
page_break = "%PAGE BREAK%"

; Text Results
;
; Number of text results to show
; per page when viewing text answers
; to surveys.
text_results_per_page = 50

; Image Extensions
;
; Comma separated list of the file extensions
; that bar graph images are allowed to have
image_extensions = "gif,jpg,jpeg,png"

; Image Width
;
; Width of image (in pixels) used
; for 100% answers on the
; survey results page
image_width = 200

; Filter Limit

; If the number of completed surveys returned
; from a filtered result set is less than or
; equal to this number, the filtered results
; will not be shown. This is to maintain
; anonominity because the answers could
; possibly be filtered such that the results
; from a single person could be identified.
; IT IS STRONGLY RECOMMENDED YOU KEEP THIS
; THIS NUMBER AT 3 OR HIGHER TO MAINTAIN
; ANONYMITY.
filter_limit = 3

; Track IP Addresses
;
; If set, the IP address
; of the user will be tracked in
; the 'ip_track' table. These IPs
; cannot be related back to the
; answers the user gave in any way.
; The program does not currently make
; use of the IP addresses, so you
; would need to implement a system to
; react to the stored IP addresses
; 0 = OFF
; 1 = ON
track_ip = 0

; Text Filter
;
; A comma separated list of words that
; will not be saved in the database if
; they are the sole response in text
; answers. For example, if users just
; type "none" or "n/a" into the text box,
; they will not be saved. Leave empty
; to not filter anything from user's answers
text_filter = "none, na, n/a, no, nothing, nope, asdf"

; Text Modes
;
; The following two settings control the display of
; text provided as a part of the survey text (questions,
; answer values, etc) and as a part of the
; user-supplied text. Although the mode is
; controlled on a per-survey basis by it's
; creator, they cannot go over the setting
; you provide here.
;
; There are three text modes you can have
; in the survey system.
;
; 0 = Text only. All input is shown as plain text
; 1 = Limited HTML. <b>, <i>, <u>, <div>, <span>, <a>, and <img>
;     tags are allowed. All other tags are shown as plain text
; 2 = Full HTML. Text is shown as supplied
;     including any HTML, Javascript, images, etc.
;
; WARNING: Allowing FULL HTML is a security risk. You
;     are letting users write the HTML for the page
;     and they could introduce malicious code. It is
;     recommended that you never use Full HTML mode for
;     the user-supplied text and only use it for survey
;     text under very controlled situations.
;
; Survey Text Mode (default is 1)
survey_text_mode = 2
;
; User Text Mode (default is 0)
user_text_mode = 0

; Date Format
;
; Default format used to report date and times when
; viewing table results or exporting results
; to a CSV file. This must match the specifications
; given at http://www.php.net/manual/en/function.date.php
; This format is also used to report the Survey
; creation date on the Edit Properties page.
;
date_format = "Y-m-d H:i"

; Survey Creation Access
;
; This setting will control whether the
; creation of surveys on the site is open
; to the public or restricted to administrators
; and the users they create and designate
;
; Options:
; public  - Anyone having access to the
;           site can create a survey
; private - Only administrators and designated
;           users can create surveys
create_access = private

;;;;;;;;;;;;;;;;;;;;;;;;;
;Database Configuration ;
;;;;;;;;;;;;;;;;;;;;;;;;;


; Database Type (mysql, mssql, etc)
db_type = mysql

; Database Host
db_host =localhost

; Database User
db_user =consulta

; Database Password
db_password =AdminNOTASwf2004

; Database Name
db_database = sala

; Database Table Prefix
;
; Use this to create your tables for
; this survey program with
; a prefix, so they are not confused
; with other tables from other
; programs in the same database. Leave
; blank for no prefix and to use the
; default table names.
db_tbl_prefix = "enc_"

; Database / HTML Character Set
;
; Sets character set for database tables
; and HTML pages. Supported character sets:
; ----
; UTF-8 - Western European (default)
; UTF-8 - ASCII compatible multi-byte 8-bit Unicode
; cp1251 - Windows specific Cyrillic charset
; KOI8-R - Russian
; BIG5 - Traditional Chinese, mainly used in Taiwan
; gb2312 - Simplified Chinese, national standard character set
; Shift_JIS - Japanese
; ----
; Supported character sets depends upon database support
; and PHP support for the htmlentities() function. Consult
; your MySQL and PHP documentation to see if other
; character sets are supported.
charset = "UTF-8"

;;;;;;;;;;;;;;;;;;;;;;;;
; SMARTY CONFIGURATION ;
;;;;;;;;;;;;;;;;;;;;;;;;

; Path to Smarty
;
; If you have your own installation
; of Smarty and do not want to use
; the one included with this program,
; provide the full system path to the
; Smarty.class.php file. Do not include
; trailing slash. Leave blank to use
; the version of Smarty included with
; this program.
smarty_path = 

;;;;;;;;;;;;;;;;;;;;;;;
; ADOdb Configuration ;
;;;;;;;;;;;;;;;;;;;;;;;

; Path to ADOdb
;
; If you have your own installation of
; ADOdb, provide the full system path to
; the adodb.inc.php file. Do not include
; trailing slash. Leave blank to use the
; version of ADOdb that comes with the
; program.
adodb_path = 

;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
; UCCASS Configuration File ;
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;