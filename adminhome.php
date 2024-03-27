<?php
include './adminheader.php';
if(isset($_GET['st'])) {
    $result = mysqli_query($link, "select clothname,stock from cloth");
    $s="";
    while($row = mysqli_fetch_row($result)) {
        $res = mysqli_query($link, "select lowstock,highstock from clothstock where clothname='$row[0]'");
        $r = mysqli_fetch_row($res);
        if($row[1]<=$r[0]) {
            $s.="$row[0] stock is Low. Increase Production\\n";
        } else if($row[1]>=$r[1]) {
            $s.="$row[0] stock is High. Increase Sales\\n";
        }
        mysqli_free_result($res);
    }
    mysqli_free_result($result);
    echo "<script>alert('$s')</script>";
    $_SESSION['sc']="done";
}
?>
<div style="text-align:center;">
    <div style="display:flex;justify-content:center;width: 100%; height: 60% ;background:url('images/demo/bbg.jpg');">
        <?php
        if(!isset($_POST['sub2'])) {
            ?>
            <table style="float:left;">
                <tr>
                    <td>
                        <form name="f" action="" method="post" style="float:left; margin:5%;background-color:pink;padding:2%;border-radius:10px;">
                            <table class="center_tab" style="float:left;">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="center">NEW DRESS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Dress Name</th>
                                        <td><input type="text" name="clothname" required autofocus></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="center">
                                            <input type="submit" name="sub2" value="Create">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </form>
                        <?php
                    } else if(isset($_POST['sub2'])) {
                        extract($_POST);
                        $c=mysqli_query($link, "insert into cloth(clothname) values('$clothname')");
                        if($c) {
                            echo "<div class='center'>Dress Material Created...!<br><a href='adminhome.php'>Back</a></div>";
                        } else {
                            echo "<div class='center'>".mysqli_error($link)."...!<br><a href='adminhome.php'>Back</a></div>";
                        }
                    }
                    echo "<tr><td>";
                    if(!isset($_POST['sub1'])) {
                        $res1 = mysqli_query($link, "select clothname from cloth");
                        ?>
                        <form name="f" action="" method="post" style="float:left; margin:5%;background-color:pink;padding:2%;border-radius:10px">
                            <table class="center_tab" style="float:left;">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="center">DRESS STOCK LEVEL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Dress Name</th>
                                        <td>
                                            <select name="clothname">
                                                <?php
                                                while($row = mysqli_fetch_row($res1)) {
                                                    echo "<option value='$row[0]'>$row[0]</option>";
                                                }
                                                mysqli_free_result($res1);
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Low Stock</th>
                                        <td><input type="text" name="lowstock" pattern="\d+" required></td>
                                    </tr>
                                    <tr>
                                        <th>High Stock</th>
                                        <td><input type="text" name="highstock" pattern="\d+" required></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="center">
                                            <input type="submit" name="sub1" value="Create">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </form>
                        </table>
                        <?php
                        if(isset($_GET['d'])) {
                            mysqli_query($link, "delete from cloth where clothname='$_GET[d]'");
                            echo "<script>location.href='adminhome.php'</script>";
                        }
                        $result = mysqli_query($link, "select * from cloth") or die(mysqli_error($link));
                        echo "<div  style='float:right; margin:1%;background-color:pink;padding:2%;border-radius:10px'><table class='report_tab' style='min-width:250px; float:right;'><thead><tr><th colspan='3' class='center'>DRESS MATERIAL</div>";
                        echo "<tr><th>Dress Name<th>Stock <th>Task<tbody>";
                        while($row=  mysqli_fetch_row($result)) {
                            echo "<tr>";	
                            echo "<td>".ucfirst($row[0]);
                            echo "<td>".abs($row[1]);
                            echo "<td><a href='adminhome.php?d=$row[0]' onclick=\"javascript:return confirm('Are You Sure to Delete ?')\">Delete</a>";
                        }
                        echo "</tbody></table>";
                        mysqli_free_result($result);
                    } else {
                        extract($_POST);    
                        $b=mysqli_query($link, "insert into clothstock(clothname,lowstock,highstock) values('$clothname','$lowstock','$highstock')");
                        if(!$b) {
                            mysqli_query($link, "update clothstock set lowstock='$lowstock',highstock='$highstock' where clothname='$clothname'");    
                        }
                        echo "<div class='center'>Stock Level Updated...!<br><a href='adminhome.php'>Back</a></div>";

                    }
                    include './adminfooter.php';
                    ?> 
    </div>
</div>