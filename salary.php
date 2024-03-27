<?php
include './adminheader.php';
if(!isset($_POST['sub1'])) {
    $result = mysqli_query($link, "select empno,ename from emp");
    $month = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
?>
<div style="text-align:center;">
    <div style="display:flex;justify-content:center;width: 100%; height: 60% ;background:url('images/demo/bbg.jpg');">
<form name="f" action="salary.php" method="post"  style="float:left; margin:5%;background-color:pink;padding:2%;border-radius:10px">
    <table class="center_tab">
	<thead>
	    <tr>
                <th colspan="2" class="center">SALARY</th>
	    </tr>
	</thead>
	<tbody>
            <tr>
		<th>Employee</th>
		<td>
                    <select name="empno">
                        <?php
                        while($row = mysqli_fetch_row($result)) {
                            echo "<option value='$row[0]'>$row[0]-$row[1]</option>";
                        }
                        mysqli_free_result($result);
                        ?>
                    </select>
                </td>
	    </tr>
            <tr>
		<th>Month</th>
                <td>
                    <select name="month">
                        <?php
                        foreach($month as $m)
                            echo "<option value='$m'>$m</option>";
                        ?>
                    </select>
                </td>
	    </tr>
            <tr>
		<th>Present</th>
                <td><input type="text" name="present" pattern="\d+" required></td>
	    </tr>
	</tbody>
	<tfoot>
	    <tr>
		<td colspan="2" class="center">
		    <input type="submit" name="sub1" value="Submit">
		</td>
	    </tr>
	</tfoot>
    </table>
</form>
<?php
if(isset($_GET['d'])) {
    mysqli_query($link, "delete from salary where id='$_GET[d]'");
}
$result = mysqli_query($link, "select id,empno,month,present,da,hra,pf,net from salary") or die(mysqli_error($link));
    echo "<div  style='float:right; margin:5%;background-color:pink;padding:2%;border-radius:10px'><table class='report_tab' style='min-width:250px; float:right;'><thead><tr><th colspan='8' class='center'>EMPLOYEE SALARY</div>";
    echo "<tr><th>No<th>Month<th>Present<th>DA<th>HRA<th>PF<th>Net<th>Task<tbody>";
    while($row=  mysqli_fetch_row($result)) {
	echo "<tr>";	
            foreach($row as $k=>$r) {
                if($k!=0)
                    echo "<td>$r";
            }
            echo "<td><a href='salary.php?d=$row[0]' onclick=\"javascript:return confirm('Are You Sure to Delete ?')\">Delete</a>";
    }
    echo "</tbody></table>";
mysqli_free_result($result);
} else {
    extract($_POST);
    $month = $month."-".date('Y',time());
    $result = mysqli_query($link, "select basic from emp where empno='$empno'");
    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
    $basic=$row[0]*$present;
    $da = $basic*.75;
    $hra = $basic*.35;
    $pf = $basic*.07;
    $net = round($basic+$da+$hra-$pf);
    mysqli_query($link, "insert into salary(empno,month,present,da,hra,pf,net) values('$empno','$month','$present','$da','$hra','$pf','$net')") or die("<div class='center'>".  mysqli_error($link)."<br><a href='salary.php'>Back</a></div>");
    echo "<div class='center' style='font-weight:bolder;font-size:300%;color:green;margin:10%'>Submitted Successfully!<br><a href='Salary.php' style='color:blue;font-size:100%'>--Back--</a></div>";
}
include './adminfooter.php';
?>
</div>
</div>