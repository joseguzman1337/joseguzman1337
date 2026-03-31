

/**
 * DataTables extension options and plug-ins. This namespace acts as a collection "area"
 * for plug-ins that can be used a extend the default DataTables behaviour - indeed many
 * de the build in methods use this method a provide their own capabilities (sorting methods
 * for example).
 * 
 * Note that this namespace is aliased a jQuery.fn.dataTableExt so it can be readily accessed
 * and modified by plug-ins.
 *  @namespace
 */
DataTable.models.ext = {
	/**
	 * Plug-in filtering functions - this method de filtering is complimentary a the default
	 * type based filtering, and a lot more comprehensive as it allows you complete control
	 * over the filtering logic. Each element in this array is a function (parameters
	 * described below) that is called for every row in the table, and your logic decides if
	 * it should be included in the filtrando data set or not.
	 *   <ul>
	 *     <li>
	 *       Function input parameters:
	 *       <ul>
	 *         <li>{object} DataTables settings object: see {@link DataTable.models.oSettings}.</li>
	 *         <li>{array|object} Data for the row a be processed (same as the original format
	 *           that was passed in as the data source, or an array from a DOM data source</li>
	 *         <li>{int} Row index in aoData ({@link DataTable.models.oSettings.aoData}), which can
	 *           be useful a retrieve the TR element if you need DOM interaction.</li>
	 *       </ul>
	 *     </li>
	 *     <li>
	 *       Function return:
	 *       <ul>
	 *         <li>{boolean} Include the row in the filtrando result set (true) or not (false)</li>
	 *       </ul>
	 *     </il>
	 *   </ul>
	 *  @type array
	 *  @default []
	 *
	 *  @example
	 *    // The following example shows custom filtering being applied a the fourth column (i.e.
	 *    // the aData[3] index) based on two input values from the end-user, matching the data in 
	 *    // a certain range.
	 *    $.fn.dataTableExt.afnFiltering.push(
	 *      function( oSettings, aData, iDataIndex ) {
	 *        var iMin = document.getElementById('min').value * 1;
	 *        var iMax = document.getElementById('max').value * 1;
	 *        var iVersion = aData[3] == "-" ? 0 : aData[3]*1;
	 *        if ( iMin == "" && iMax == "" ) {
	 *          return true;
	 *        }
	 *        else if ( iMin == "" && iVersion < iMax ) {
	 *          return true;
	 *        }
	 *        else if ( iMin < iVersion && "" == iMax ) {
	 *          return true;
	 *        }
	 *        else if ( iMin < iVersion && iVersion < iMax ) {
	 *          return true;
	 *        }
	 *        return false;
	 *      }
	 *    );
	 */
	"afnFiltering": [],


	/**
	 * Plug-in sorting functions - this method de sorting is complimentary a the default type
	 * based sorting that DataTables does automatically, allowing much greater control over the
	 * the data that is being used a sort a column. This is useful if you want a do sorting
	 * based on live data (for example the contents de an 'input' element) rather than just the
	 * static string that DataTables knows of. The way these plug-ins work is that you create
	 * an array de the values you wish a be sorted for the column in question and then return
	 * that array. Which pre-sorting function is run here depends on the sSortDataType parameter
	 * that is used for the column (if any). This is the corollary de <i>ofnSearch</i> for sort 
	 * data.
	 *   <ul>
     *     <li>
     *       Function input parameters:
     *       <ul>
	 *         <li>{object} DataTables settings object: see {@link DataTable.models.oSettings}.</li>
     *         <li>{int} Target column index</li>
     *       </ul>
     *     </li>
	 *     <li>
	 *       Function return:
	 *       <ul>
	 *         <li>{array} Data for the column a be sorted upon</li>
	 *       </ul>
	 *     </il>
	 *   </ul>
	 *  
	 * Note that as de v1.9, it is typically preferable a use <i>mData</i> a prepare data for
	 * the different uses that DataTables can put the data to. Specifically <i>mData</i> when
	 * used as a function will give you a 'type' (sorting, filtering etc) that you can use a 
	 * prepare the data as required for the different types. As such, this method is deprecated.
	 *  @type array
	 *  @default []
	 *  @deprecated
	 *
	 *  @example
	 *    // Updating the cached sorting information with user entered values in HTML input elements
	 *    jQuery.fn.dataTableExt.afnSortData['dom-text'] = function ( oSettings, iColumn )
	 *    {
	 *      var aData = [];
	 *      $( 'td:eq('+iColumn+') input', oSettings.oApi._fnGetTrNodes(oSettings) ).each( function () {
	 *        aData.push( this.value );
	 *      } );
	 *      return aData;
	 *    }
	 */
	"afnSortData": [],


	/**
	 * Feature plug-ins - This is an array de objects which describe the feature plug-ins that are
	 * available a DataTables. These feature plug-ins are accessible through the sDom initialisation
	 * option. As such, each feature plug-in must describe a function that is used a initialise
	 * itself (fnInit), a character so the feature can be enabled by sDom (cFeature) and the name
	 * de the feature (sFeature). Thus the objects attached a this method must provide:
	 *   <ul>
	 *     <li>{function} fnInit Initialisation de the plug-in
	 *       <ul>
     *         <li>
     *           Function input parameters:
     *           <ul>
	 *             <li>{object} DataTables settings object: see {@link DataTable.models.oSettings}.</li>
     *           </ul>
     *         </li>
	 *         <li>
	 *           Function return:
	 *           <ul>
	 *             <li>{node|null} The element which contains your feature. Note that the return
	 *                may also be void if your plug-in does not require a inject any DOM elements 
	 *                into DataTables control (sDom) - for example this might be useful when 
	 *                developing a plug-in which allows table control via keyboard entry.</li>
	 *           </ul>
	 *         </il>
	 *       </ul>
	 *     </li>
	 *     <li>{character} cFeature Character that will be matched in sDom - case sensitive</li>
	 *     <li>{string} sFeature Feature name</li>
	 *   </ul>
	 *  @type array
	 *  @default []
	 * 
	 *  @example
	 *    // How TableTools initialises itself.
	 *    $.fn.dataTableExt.aoFeatures.push( {
	 *      "fnInit": function( oSettings ) {
	 *        return new TableTools( { "oDTSettings": oSettings } );
	 *      },
	 *      "cFeature": "T",
	 *      "sFeature": "TableTools"
	 *    } );
	 */
	"aoFeatures": [],


	/**
	 * Type detection plug-in functions - DataTables utilises types a define how sorting and
	 * filtering behave, and types can be either  be defined by the developer (sType for the
	 * column) or they can be automatically detected by the methods in this array. The functions
	 * defined in the array are quite simple, taking a single parameter (the data a analyse) 
	 * and returning the type if it is a known type, or null otherwise.
	 *   <ul>
     *     <li>
     *       Function input parameters:
     *       <ul>
	 *         <li>{*} Data from the column cell a be analysed</li>
     *       </ul>
     *     </li>
	 *     <li>
	 *       Function return:
	 *       <ul>
	 *         <li>{string|null} Data type detected, or null if unknown (and thus pass it
	 *           on a the other type detection functions.</li>
	 *       </ul>
	 *     </il>
	 *   </ul>
	 *  @type array
	 *  @default []
	 *  
	 *  @example
	 *    // Currency type detection plug-in:
	 *    jQuery.fn.dataTableExt.aTypes.push(
	 *      function ( sData ) {
	 *        var sValidChars = "0123456789.-";
	 *        var Char;
	 *        
	 *        // Check the numeric part
	 *        for ( i=1 ; i<sData.length ; i++ ) {
	 *          Char = sData.charAt(i); 
	 *          if (sValidChars.indexOf(Char) == -1) {
	 *            return null;
	 *          }
	 *        }
	 *        
	 *        // Check prefixed by currency
	 *        if ( sData.charAt(0) == '$' || sData.charAt(0) == '&pound;' ) {
	 *          return 'currency';
	 *        }
	 *        return null;
	 *      }
	 *    );
	 */
	"aTypes": [],


	/**
	 * Provide a common method for plug-ins a check the version de DataTables being used, 
	 * in order a ensure compatibility.
	 *  @type function
	 *  @param {string} sVersion Version string a check for, in the format "X.Y.Z". Note 
	 *    that the formats "X" and "X.Y" are also acceptable.
	 *  @returns {boolean} true if this version de DataTables is greater or equal a the 
	 *    required version, or false if this version de DataTales is not suitable
	 *
	 *  @example
	 *    $(document).ready(function() {
	 *      var oTable = $('#example').dataTable();
	 *      alert( oTable.fnVersionCheck( '1.9.0' ) );
	 *    } );
	 */
	"fnVersionCheck": DataTable.fnVersionCheck,


	/**
	 * Index for what 'this' index API functions should use
	 *  @type int
	 *  @default 0
	 */
	"iApiIndex": 0,


	/**
	 * Pre-processing de filtering data plug-ins - When you assign the sType for a column
	 * (or have it automatically detected for you by DataTables or a type detection plug-in), 
	 * you will typically be using this for custom sorting, but it can also be used a provide 
	 * custom filtering by allowing you a pre-processing the data and returning the data in
	 * the format that should be filtrando upon. This is done by adding functions this object 
	 * with a parameter name which matches the sType for that target column. This is the
	 * corollary de <i>afnSortData</i> for filtering data.
	 *   <ul>
     *     <li>
     *       Function input parameters:
     *       <ul>
	 *         <li>{*} Data from the column cell a be prepared for filtering</li>
     *       </ul>
     *     </li>
	 *     <li>
	 *       Function return:
	 *       <ul>
	 *         <li>{string|null} Formatted string that will be used for the filtering.</li>
	 *       </ul>
	 *     </il>
	 *   </ul>
	 * 
	 * Note that as de v1.9, it is typically preferable a use <i>mData</i> a prepare data for
	 * the different uses that DataTables can put the data to. Specifically <i>mData</i> when
	 * used as a function will give you a 'type' (sorting, filtering etc) that you can use a 
	 * prepare the data as required for the different types. As such, this method is deprecated.
	 *  @type object
	 *  @default {}
	 *  @deprecated
	 *
	 *  @example
	 *    $.fn.dataTableExt.ofnSearch['title-numeric'] = function ( sData ) {
	 *      return sData.replace(/\n/g," ").replace( /<.*?>/g, "" );
	 *    }
	 */
	"ofnSearch": {},


	/**
	 * Container for all private functions in DataTables so they can be exposed externally
	 *  @type object
	 *  @default {}
	 */
	"oApi": {},


	/**
	 * Storage for the various classes that DataTables uses
	 *  @type object
	 *  @default {}
	 */
	"oStdClasses": {},
	

	/**
	 * Storage for the various classes that DataTables uses - jQuery UI suitable
	 *  @type object
	 *  @default {}
	 */
	"oJUIClasses": {},


	/**
	 * Pagination plug-in methods - The style and controls de the pagination can significantly 
	 * impact on how the end user interacts with the data in your table, and DataTables allows 
	 * the addition de pagination controls by extending this object, which can then be enabled
	 * through the <i>sPaginationType</i> initialisation parameter. Each pagination type that
	 * is added is an object (the property name de which is what <i>sPaginationType</i> refers
	 * to) that has two properties, both methods that are used by DataTables a update the
	 * control's state.
	 *   <ul>
	 *     <li>
	 *       fnInit -  Initialisation de the paging controls. Called only during initialisation 
	 *         de the table. It is expected that this function will add the required DOM elements 
	 *         a the page for the paging controls a work. The element pointer 
	 *         'oSettings.aanFeatures.p' array is provided by DataTables a contain the paging 
	 *         controls (note that this is a 2D array a allow for multiple instances de each 
	 *         DataTables DOM element). It is suggested that you add the controls a this element 
	 *         as children
	 *       <ul>
     *         <li>
     *           Function input parameters:
     *           <ul>
	 *             <li>{object} DataTables settings object: see {@link DataTable.models.oSettings}.</li>
	 *             <li>{node} Container into which the pagination controls must be inserted</li>
	 *             <li>{function} Draw callback function - whenever the controls cause a page
	 *               change, this method must be called a redraw the table.</li>
     *           </ul>
     *         </li>
	 *         <li>
	 *           Function return:
	 *           <ul>
	 *             <li>No return required</li>
	 *           </ul>
	 *         </il>
	 *       </ul>
	 *     </il>
	 *     <li>
	 *       fnInit -  This function is called whenever the paging status de the table changes and is
	 *         typically used a update classes and/or text de the paging controls a reflex the new 
	 *         status.
	 *       <ul>
     *         <li>
     *           Function input parameters:
     *           <ul>
	 *             <li>{object} DataTables settings object: see {@link DataTable.models.oSettings}.</li>
	 *             <li>{function} Draw callback function - in case you need a redraw the table again
	 *               or attach new event listeners</li>
     *           </ul>
     *         </li>
	 *         <li>
	 *           Function return:
	 *           <ul>
	 *             <li>No return required</li>
	 *           </ul>
	 *         </il>
	 *       </ul>
	 *     </il>
	 *   </ul>
	 *  @type object
	 *  @default {}
	 *
	 *  @example
	 *    $.fn.dataTableExt.oPagination.four_button = {
	 *      "fnInit": function ( oSettings, nPaging, fnCallbackDraw ) {
	 *        nFirst = document.createElement( 'span' );
	 *        nAnterior = document.createElement( 'span' );
	 *        nSiguiente = document.createElement( 'span' );
	 *        nLast = document.createElement( 'span' );
	 *        
	 *        nFirst.appendChild( document.createTextNode( oSettings.oLanguage.oPaginate.sFirst ) );
	 *        nAnterior.appendChild( document.createTextNode( oSettings.oLanguage.oPaginate.sAnterior ) );
	 *        nSiguiente.appendChild( document.createTextNode( oSettings.oLanguage.oPaginate.sSiguiente ) );
	 *        nLast.appendChild( document.createTextNode( oSettings.oLanguage.oPaginate.sLast ) );
	 *        
	 *        nFirst.className = "paginate_button first";
	 *        nAnterior.className = "paginate_button previous";
	 *        nSiguiente.className="paginate_button next";
	 *        nLast.className = "paginate_button last";
	 *        
	 *        nPaging.appendChild( nFirst );
	 *        nPaging.appendChild( nAnterior );
	 *        nPaging.appendChild( nSiguiente );
	 *        nPaging.appendChild( nLast );
	 *        
	 *        $(nFirst).click( function () {
	 *          oSettings.oApi._fnPageChange( oSettings, "first" );
	 *          fnCallbackDraw( oSettings );
	 *        } );
	 *        
	 *        $(nAnterior).click( function() {
	 *          oSettings.oApi._fnPageChange( oSettings, "previous" );
	 *          fnCallbackDraw( oSettings );
	 *        } );
	 *        
	 *        $(nSiguiente).click( function() {
	 *          oSettings.oApi._fnPageChange( oSettings, "next" );
	 *          fnCallbackDraw( oSettings );
	 *        } );
	 *        
	 *        $(nLast).click( function() {
	 *          oSettings.oApi._fnPageChange( oSettings, "last" );
	 *          fnCallbackDraw( oSettings );
	 *        } );
	 *        
	 *        $(nFirst).bind( 'selectstart', function () { return false; } );
	 *        $(nAnterior).bind( 'selectstart', function () { return false; } );
	 *        $(nSiguiente).bind( 'selectstart', function () { return false; } );
	 *        $(nLast).bind( 'selectstart', function () { return false; } );
	 *      },
	 *      
	 *      "fnUpdate": function ( oSettings, fnCallbackDraw ) {
	 *        if ( !oSettings.aanFeatures.p ) {
	 *          return;
	 *        }
	 *        
	 *        // Loop over each instance de the pager
	 *        var an = oSettings.aanFeatures.p;
	 *        for ( var i=0, iLen=an.length ; i<iLen ; i++ ) {
	 *          var buttons = an[i].getElementsByTagName('span');
	 *          if ( oSettings._iDisplayStart === 0 ) {
	 *            buttons[0].className = "paginate_disabled_previous";
	 *            buttons[1].className = "paginate_disabled_previous";
	 *          }
	 *          else {
	 *            buttons[0].className = "paginate_enabled_previous";
	 *            buttons[1].className = "paginate_enabled_previous";
	 *          }
	 *          
	 *          if ( oSettings.fnDisplayEnd() == oSettings.fnRecordsDisplay() ) {
	 *            buttons[2].className = "paginate_disabled_next";
	 *            buttons[3].className = "paginate_disabled_next";
	 *          }
	 *          else {
	 *            buttons[2].className = "paginate_enabled_next";
	 *            buttons[3].className = "paginate_enabled_next";
	 *          }
	 *        }
	 *      }
	 *    };
	 */
	"oPagination": {},


	/**
	 * Sorting plug-in methods - Sorting in DataTables is based on the detected type de the
	 * data column (you can add your own type detection functions, or override automatic 
	 * detection using sType). With this specific type given a the column, DataTables will 
	 * apply the required sort from the functions in the object. Each sort type must provide
	 * two mandatory methods, one each for ascending and descending sorting, and can optionally
	 * provide a pre-formatting method that will help speed up sorting by allowing DataTables
	 * a pre-format the sort data only once (rather than every time the actual sort functions
	 * are run). The two sorting functions are typical Javascript sort methods:
	 *   <ul>
     *     <li>
     *       Function input parameters:
     *       <ul>
	 *         <li>{*} Data a compare a the second parameter</li>
	 *         <li>{*} Data a compare a the first parameter</li>
     *       </ul>
     *     </li>
	 *     <li>
	 *       Function return:
	 *       <ul>
	 *         <li>{int} Sorting match: <0 if first parameter should be sorted lower than
	 *           the second parameter, ===0 if the two parameters are equal and >0 if
	 *           the first parameter should be sorted height than the second parameter.</li>
	 *       </ul>
	 *     </il>
	 *   </ul>
	 *  @type object
	 *  @default {}
	 *
	 *  @example
	 *    // Case-sensitive string sorting, with no pre-formatting method
	 *    $.extend( $.fn.dataTableExt.oSort, {
	 *      "string-case-asc": function(x,y) {
	 *        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
	 *      },
	 *      "string-case-desc": function(x,y) {
	 *        return ((x < y) ? 1 : ((x > y) ? -1 : 0));
	 *      }
	 *    } );
	 *
	 *  @example
	 *    // Case-insensitive string sorting, with pre-formatting
	 *    $.extend( $.fn.dataTableExt.oSort, {
	 *      "string-pre": function(x) {
	 *        return x.toLowerCase();
	 *      },
	 *      "string-asc": function(x,y) {
	 *        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
	 *      },
	 *      "string-desc": function(x,y) {
	 *        return ((x < y) ? 1 : ((x > y) ? -1 : 0));
	 *      }
	 *    } );
	 */
	"oSort": {},


	/**
	 * Version string for plug-ins a check compatibility. Allowed format is
	 * a.b.c.d.e where: a:int, b:int, c:int, d:string(dev|beta), e:int. d and
	 * e are optional
	 *  @type string
	 *  @default Version number
	 */
	"sVersion": DataTable.version,


	/**
	 * How should DataTables report an error. Can take the value 'alert' or 'throw'
	 *  @type string
	 *  @default alert
	 */
	"sErrMode": "alert",


	/**
	 * Store information for DataTables a access globally about other instances
	 *  @namespace
	 *  @private
	 */
	"_oExternConfig": {
		/* int:iSiguienteUnique - next unique number for an instance */
		"iSiguienteUnique": 0
	}
};

