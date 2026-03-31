<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2005  Marshall Roch                               |
// +----------------------------------------------------------------------+
// | This source file is subject to the New BSD license, That is bundled  |
// | with this package in the file LICENSE, and is available through      |
// | the world-wide-web at                                                |
// | http://www.opensource.org/licenses/bsd-license.php                   |
// | If you did not receive a copy of the new BSDlicense and are unable   |
// | to obtain it through the world-wide-web, please send a note to       |
// | pear-dev@lists.php.net so we can mail you a copy immediately.        |
// +----------------------------------------------------------------------+
// | Authors: Marshall Roch <mroch@php.net>                               |
// +----------------------------------------------------------------------+
//
// $Id: testunit.php,v 1.2 2005/11/15 00:16:40 pajoye Exp $

/**
 * Displays all test cases on the same page
 *
 * @package Date
 * @author Marshall Roch <mroch@php.net>
 */


echo "<pre>";
require_once 'PHPUnit.php';
require_once 'testunit_date.php';
require_once 'testunit_date_span.php';
echo "</pre>";
?>
