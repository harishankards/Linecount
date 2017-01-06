<style>
#txtlzr
{
	font-family:"Arial Black";
	color:#6699FF;
	font-size: 15px;
	width: 250px;
	height: 200px;
	margin-left: 4px;
	margin-top: 0px;
	padding:10px 0px 10px 10px;
	letter-spacing:3px;
	line-height:20px;
}
</style>

<script>
$(function() {
	  var txt = $('#txtlzr'); 
	  txt.textualizer();
	  txt.textualizer('start');
});
</script>
<div id="container"> 
    <div id="txtlzr">
        <?php
	    
            $pastdays = date("Y")."-".date("m")."-".(date("d")-10);
	    $today = date("Y-m-d");
            $query_string = "SELECT * FROM `notes` WHERE `Date` BETWEEN '$pastdays' AND '$today'";
	    	
            $note_sql=mysql_query($query_string);
	    //echo $query_string;
            $note_count=mysql_num_rows($note_sql);
            if($note_count!=0)
            {
                while($note_row=mysql_fetch_array($note_sql))
                {
                    if($note_row['Note']!='')
                    {
                        $msg=trim($note_row['Note']);
                        $string = preg_replace("/\s+/"," ",$msg);
                        if(!strpos("+",$string))
                        {
                            $pattern = array("/^[\s+]/","/[\s+]$/","/\s/");
                            $replace = array("",""," ");
                            $string = preg_replace($pattern,$replace,$string);
                        }
                        echo "<p>".$string."</p>";
                    }
                }
            }
        ?>
    </div> 
</div>  