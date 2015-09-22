<?php
class paginate
{
     private $db;
 
     function __construct($DB_con)
     {
         $this->db = $DB_con;
     }
 
     public function dataview($query)
     {
         $stmt = $this->db->prepare($query);
         $stmt->execute();
		 $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
         if($stmt->rowCount()>0)
         {
                foreach($results as $key=>$row) {
					echo "<div class='post-container-";
					if($key % 2 == 0)
						echo "even";
					else
						echo "odd";
					echo "'>";
					
					echo '<table border = "1" style = "width:100%">
					<tr>';
					echo 
					"<td> <a href='/userprofile.php?userprofile=" . $row['username'] . "'>". $row['fname'] . '</a></td>
					<td>Date Posted: ' .$row['postdate'] . '</td>';
					
					if($_SESSION['accesslvl'] == "admin" || $_SESSION['id'] == $row['acc_id']){
						echo '<td><button class="editpost">Edit</button></td>
						<td><form class="post-form" action="/deletepost.php" method="POST">
	    				<input type="hidden" name="post_id" value="' . $row['id'] . '"/>
	    				<input type="submit" value="Delete"/>
	    				</form></td>';
					}
					
					echo "</tr>
					<tr>
					<td><a href='/userprofile.php?userprofile=" . $row['username'] . "'>" . $row['username'] . '</a></td>
					<td colspan="3">
					
					<div class = "textpost" id="'. $row['id'] .'">'. strip($row['content']) . '</div>
					</td>
					</tr>
					<tr>
					<td>Date Joined:'  . $_SESSION['joindate'] . '</td>
					<td colspan="3">Last Edited: ' . $row['last_edited'] . '</td>
					</tr>
					</table>';
					echo "</div>";
				}
         }
         else
         {
                ?>
                <tr>
                <td>No posts.</td>
                </tr>
                <?php
         }
  
 }
 
 public function paging($query,$records_per_page)
 {
        $starting_position=0;
        if(isset($_GET["page_no"]))
        {
             $starting_position=($_GET["page_no"]-1)*$records_per_page;
        }
        $query2=$query." limit $starting_position,$records_per_page";
        return $query2;
 }
 
 public function paginglink($query,$records_per_page)
 {
        $self = htmlspecialchars($_SERVER['PHP_SELF']);
  
        $stmt = $this->db->prepare($query);
        $stmt->execute();
  
        $total_no_of_records = $stmt->rowCount();
  
        if($total_no_of_records > 0)
        {
            ?><tr><td colspan="3"><?php
            $total_no_of_pages=ceil($total_no_of_records/$records_per_page);
            $current_page=1;
            if(isset($_GET["page_no"]))
            {
               $current_page=$_GET["page_no"];
            }
            if($current_page!=1)
            {
               $previous =$current_page-1;
               echo "<a href='".$self."?page_no=1'>First</a>&nbsp;&nbsp;";
               echo "<a href='".$self."?page_no=".$previous."'>Previous</a>&nbsp;&nbsp;";
            }
            for($i=1;$i<=$total_no_of_pages;$i++)
            {
            if($i==$current_page)
            {
                echo "<strong><a href='".$self."?page_no=".$i."' style='color:red;text-decoration:none'>".$i."</a></strong>&nbsp;&nbsp;";
            }
            else
            {
                echo "<a href='".$self."?page_no=".$i."'>".$i."</a>&nbsp;&nbsp;";
            }
   }
   if($current_page!=$total_no_of_pages)
   {
        $next=$current_page+1;
        echo "<a href='".$self."?page_no=".$next."'>Next</a>&nbsp;&nbsp;";
        echo "<a href='".$self."?page_no=".$total_no_of_pages."'>Last</a>&nbsp;&nbsp;";
   }
   ?></td></tr><?php
  }
 }
}