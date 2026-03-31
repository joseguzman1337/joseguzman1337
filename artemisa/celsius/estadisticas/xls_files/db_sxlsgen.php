<?php
/****************************************************************
* Script         : Database functions for PhpSimpleXlsGen Class
* Project        : PHP SimpleXlsGen
* Author         : Erol Ozcan <eozcan@superonline.com>
* Version        : 0.3
* Copyright      : GNU LGPL
* URL            : http://psxlsgen.sourceforge.net
* Last modified  : 13 Jun 2001
******************************************************************/

if( !defined( "DB_SIMPLE_XLS_GEN" ) ) {
   define( "DB_SIMPLE_XLS_GEN", 1 );

   Class Db_SXlsGen extends PhpSimpleXlsGen {
      var $db_class_ver = "0.3";
      var $db_host     = "localhost";
      var $db_user     = "root";
      var $db_passwd   = "TrySome@Home!";
      var $db_name     = "Emiliano";
      var $db_type     = "mysql";
      var $db_con_id   = "";
      var $db_query    = "";
      var $db_stmt     = "";
      var $db_ncols    = 0;
      var $db_nrows    = 0;
      var $db_fetchrow = array();
      var $col_aliases = array();
      var $db_close    = 1;      // 0 = no close db connection after query fetched, 1 = close it


      // default constructor
      function CDb_SXlsGen()
      {
         $this->PhpSimpleXlsGen();
      }

      // insert column names with checking their aliases
      function InsertColNames( $cmd_colname )
      {
         $this->totalcol = $this->db_ncols;
         for( $i = 0; $i < $this->db_ncols; $i++ ) {
            // variable function is used
            $col = $cmd_colname( $this->db_stmt, $i );
            if ( $this->col_aliases["$col"] != "" ) {
               $colname = $this->col_aliases[$col];
            } else {
               $colname = $col;
            }
            $this->InsertText( $colname );
         }
      }

      // insert rows result of query
      function InsertRows( $cmd_rowfetch )
      {
         $row = array();
         for( $i = 0; $i < $this->db_nrows; $i++ ) {
           if ( $this->db_type == "pgsql" ) {
              $row = $cmd_rowfetch( $this->db_stmt, $i );
           } else {
              $row = $cmd_rowfetch( $this->db_stmt );
           }
           for ( $j = 0; $j < $this->db_ncols; $j++ ) {
              $this->InsertText( $row[$j] );
           }
         }
      }

      function FetchData()
      {
         switch ( $this->db_type ) {
            case "mysql":
                  if ( $this->db_con_id == "" ) {
                    $this->db_con_id = mysql_connect( $this->db_host, $this->db_user, $this->db_passwd );
                  }
                  $this->db_stmt = mysql_db_query( $this->db_name, $this->db_query, $this->db_con_id );
                  $this->db_ncols = mysql_num_fields( $this->db_stmt );
                  $this->InsertColNames( "mysql_field_name" );
                  $this->db_nrows = mysql_num_rows( $this->db_stmt );
                  $this->InsertRows( "mysql_fetch_array" );
                  mysql_free_result ( $this->db_stmt );
                  if ( $this->db_close ) {
                    mysql_close( $this->db_con_id );
                  }
                  break;

            case "pgsql":
                  if ( $this->db_con_id == "" ) {
                     $this->db_con_id = pg_connect( "host=".$this->db_host." dbname=".$this->db_name." user=".$this->db_user." password=".$this->db_passwd );
                  }
                  $this->db_stmt = pg_exec( $this->db_con_id, $this->db_query );
                  $this->db_ncols = pg_numfields( $this->db_stmt );
                  $this->InsertColNames( "pg_fieldname" );
                  $this->db_nrows = pg_numrows( $this->db_stmt );
                  $this->InsertRows( "pg_fetch_row" );
                  pg_freeresult( $this->db_stmt );
                  if ( $this->db_close ) {
                    pg_close( $this->db_con_id );
                  }
                  break;

            case "oci8":
                  if ( $this->db_con_id == "" ) {
                     $this->db_con_id = OCILogon( $this->db_user, $this->db_passwd, $this->db_name );
                  }
                  $this->db_stmt = OCIParse( $this->db_con_id, $this->db_query );
                  OCIExecute( $this->db_stmt );
                  $this->db_ncols = OCINumCols( $this->db_stmt );
                  // fetching column names and rows are differents in OCI8.
                  $tmparr = array();
                  $this->db_nrows = OCIFetchStatement( $this->db_stmt, &$results );
                  $this->totalcol = $this->db_ncols;
                  while ( list($key, $val ) = each( $results ) ) {
                     if ( $this->col_aliases[$key] != "" ) {
                       $colname = $this->col_aliases[$key];
                     } else {
                       $colname = $key;
                     }
                     $this->InsertText( $colname );
                  }
                  for ( $i = 0; $i < $this->db_nrows; $i++ ) {
                     reset( $results );
                     while ( $column = each( $results ) ) {
                        $data = $column['value'];
                        $this->InsertText( $data[$i] );
                     }
                  }
                  OCIFreeStatement( $this->db_stmt );
                  if ( $this->db_close ) {
                     OCILogoff( $this->db_con_id );
                  }
                  break;

            case "odbc":
                  if ( $this->db_con_id == "" ) {
                     $this->db_con_id = odbc_connect( $this->db_host, $this->db_user, $this->db_passwd );
                  }
                  $this->db_stmt = odbc_exec( $this->db_con_id, $this->db_query );
                  $this->db_ncols = odbc_num_fields( $this->db_stmt );
                  $this->totalcol = $this->db_ncols;
                  for( $i = 1; $i <= $this->db_ncols; $i++ ) {
                     $col = odbc_field_name( $this->db_stmt, $i );
                     if ( $this->col_aliases["$col"] != "" ) {
                        $colname = $this->col_aliases[$col];
                     } else {
                        $colname = $col;
                     }
                     $this->InsertText( $colname );
                  }
                  $this->db_nrows = odbc_num_rows( $this->db_stmt );
                  for ( $i = 1; $i <= $this->db_nrows; $i++ ) {
                     odbc_fetch_row( $this->db_stmt, $i );
                     for ( $j = 1; $j <= $this->db_ncols; $j++ ) {
                        $colval = odbc_result( $this->db_stmt, $j );
                        $this->InsertText( $colval );
                     }
                  }
                  //odbc_freeresult( $this->db_stmt );
                  if ( $this->db_close ) {
                    odbc_close( $this->db_con_id );
                  }
                  break;

            default:
                  print "<b>Sorry, currently \"$this->db_type\" db is not supported!</b>";
                  exit();
                  break;
         }
      }

      function GetXlsFromQuery( $query )
      {
           $this->db_query = $query;
           $this->FetchData();
           $this->GetXls();
      }
   } // end of class CDb_SXlsGen
}
// end of ifdef DB_SIMPLE_XLS_GEN