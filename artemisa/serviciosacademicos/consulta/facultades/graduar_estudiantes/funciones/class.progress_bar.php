<?php
/*
*    Written by Chris Geisler - dean@apartmentlocators.com
*
*    This script is distributed under the GPL License
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    http://www.gnu.org/licenses/gpl.txt
*
*/

class progress_bar
{
	var $name;		// The name of the html element representing the progress bar.
	var $percent;   // The current percent value of the progress bar.
	var $width;     // The maximum width of the progress bar.

	/*Function progress_bar - The progress bar constructor function
	parameters:
	$name the name of the html element representing the progress bar.
	$percent the initial percent value of the progress bar.
	$width the initial width of the progress bar.
	$auto_create if set to TRUE the create() function will be called upon construction of the progress bar
	*/
	function progress_bar($name = 'pbar',$percent = 1,$width = 100,$auto_create = TRUE)
	{
		$this->name = $name;

		$this->percent = $percent;

		$this->width = $width;
		if($auto_create)
		{
			$this->create();
		}
  	}

	/*Function create() - Dispalys the progress bar as an html
	element. (Warning: do not call this function twice or if $auto_create is set to TRUE)

	parameters:
	$name sets the name of the html element
	(This function becomes usless after the create(); function is called.)*/
	function create()
	{
		?>
		<div align="center">
		  <center>
		  <table height="20" name="<?php echo('table_' . $this->name);?>" border="0" cellpadding="0" cellspacing="0" width="<?php echo($this->width + 60);?>">
			<tr>
              <td width="52" height="20"><p>Progress: </p></td>
		      <td width="4" height="20" valign="top" align="left"><img border="0" src="http://www.realestate-in-fortworth.com/admin/images/begin-filled.gif" width="4" height="20"></td>
		      <td name="<?php echo('cell_' . $this->name);?>" align="left" valign="middle" width="<?php echo($this->width);?>" height="20" style="background-repeat: repeat-x" background="http://www.realestate-in-fortworth.com/admin/images/fill_bg.gif"><img name="<?php echo($this->name)?>" border="0" src="http://www.realestate-in-fortworth.com/admin/images/fill.gif" width="<?php echo(($percent * .01) * $width);?>" height="11"></td>
		      <td width="4"  height="20" valign="top" align="left"><img border="0" src="http://www.realestate-in-fortworth.com/admin/images/end-filled.gif" width="4" height="20"></td>
		    </tr>
		  </table>
		  </center>
		</div>
		<?php
	}

	/*Function set_name() - Sets the $percent of the object based
 	on current tasks done and the total tasks to finish.

	parameters:
	$name sets the name of the html element
	(This function becomes usless after the create(); function is called.)*/
	function set_name($name)
	{
		$this->name = $name;
	}

	/*Function set_percent() - Sets the $percent of the progress bar
 	using a pre-calculated percent.

	parameters:
	$percent the pre-calculated percent*/
	function set_percent($percent)
	{
		$this->percent = $percent;

		echo('<script>document.images.' . $this->name . '.width = ' . ($this->percent / 100) * $this->width . '</script>');
	}

 	/*Function set_percent_adv() - Sets the $percent of the object based
 	on current tasks done and the total tasks to finish.

	parameters:
	$cur_amount the curent number of tasks completed in a script
	$max_amount the number of tasks to complete in a script*/
	function set_percent_adv($cur_amount,$max_amount)
	{
		$this->percent = ($cur_amount / $max_amount) * 100;
		echo('<script>document.images.' . $this->name . '.width = ' . ($this->percent / 100) * $this->width . '</script>');
	}

	/*Function set_width() - Sets the maximum $width of the progress bar.

	parameters:
	$cur_amount the curent number of tasks completed in a script
	$max_amount the number of tasks to complete in a script*/
	function set_width($width)
	{
		$this->width = $width;
	}
}

?>