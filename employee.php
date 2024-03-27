<?php
include './adminheader.php';
//include './menu.php';
if(!isset($_POST['sub1'])) {
    $result = mysqli_query($link, "select ifnull(max(empno),999)+1 from emp");
    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
?>
<div style="text-align:center;">
    <div style="display:flex;justify-content:center;width: 100%; height: 60% ;background:url('images/demo/bbg.jpg');">
<form name="f" action="employee.php" method="post" style="float:left; margin:5%;background-color:pink;padding:2%;border-radius:10px">
    <table class="center_tab">
	<thead>
	    <tr>
                <th colspan="2" class="center">EMPLOYEE</th>
	    </tr>
	</thead>
	<tbody>
            <tr>
		<th>Employee Id</th>
		<td><input type="text" name="empno" required value="<?php echo $row[0];?>"></td>
	    </tr>
	    <tr>
		<th>Employee Name</th>
		<td><input type="text" name="ename" required autofocus></td>
	    </tr>
            <tr>
		<th>Gender</th>
		<td>
                    <input type="radio" name="gender" value="Male" checked>Male &nbsp;
                    <input type="radio" name="gender" value="Female">Female
                </td>
	    </tr>
            <tr>
		<th>Address</th>
                <td><textarea name="addr" required></textarea></td>
	    </tr>
            <tr>
		<th>Mobile</th>
                <td><input type="text" name="mobile" pattern="[9876]\d{9}" required maxlength="10"></td>
	    </tr>
            <tr>
		<th>Basic Pay/Day</th>
                <td><input type="text" name="basic" pattern="\d+" required></td>
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
    mysqli_query($link, "delete from emp where empno='$_GET[d]'");
}
$result = mysqli_query($link, "select empno,ename,gender,mobile,basic from emp") or die(mysqli_error($link));
    echo "<div  style='float:right; margin:5%;background-color:pink;padding:2%;border-radius:10px'><table class='report_tab' style='min-width:250px; float:right;'><thead><tr><th colspan='6' class='center'>EMPLOYEE RECORD</div>";
    echo "<tr><th>No<th>Name<th>Gender<th>Mobile<th>Basic<th>Task<tbody>";
    while($row=  mysqli_fetch_row($result)) {
	echo "<tr>";	
            foreach($row as $k=>$r) {                
                    echo "<td>$r";
            }
            echo "<td><a href='employee.php?d=$row[0]' onclick=\"javascript:return confirm('Are You Sure to Delete ?')\">Delete</a>";
    }
    echo "</tbody></table>";
mysqli_free_result($result);
} else {
    extract($_POST);
    $dt = date('Y-m-d',time());
    mysqli_query($link, "insert into emp(empno,ename,gender,addr,mobile,basic) values('$empno','$ename','$gender','$addr','$mobile','$basic')");
    echo "<div class='center' style='font-weight:bolder;font-size:300%;color:green;margin:10%'>Employee Created!<br><a href='employee.php' style='color:blue;font-size:100%'>--Back--</a></div>";
}
include './adminfooter.php';
?>
</div>
</div>