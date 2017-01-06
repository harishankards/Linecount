 // Date range Picker
    $(function() {
        $( "#from" ).datepicker({
            defaultDate:"<?php echo date('Y-m-d');?>",
            changeMonth: false,
            numberOfMonths: 1,
			dateFormat: "yy-mm-dd",
			showAnim: "clip",
            onClose: function( selectedDate ) {
                $( "#to" ).datepicker( "option", "minDate", selectedDate );
            }
			
        });
        $( "#to" ).datepicker({
            defaultDate: "+1w",
            changeMonth: false,
            numberOfMonths: 2,
			showAnim: "clip",
			dateFormat: "yy-mm-dd",
            onClose: function( selectedDate ) {
                $( "#from" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
    });
	//Data Deletion Date for database clearance
	 $(function() {
        $( "#from_del" ).datepicker({
            defaultDate:"<?php echo date('Y-m-d');?>",
            changeMonth: false,
            numberOfMonths: 1,
			dateFormat: "yy-mm-dd",
			showAnim: "clip",
			maxDate: "-4M"
        });
        $( "#to_del" ).datepicker({
            defaultDate: "+1w",
            changeMonth: false,
            numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			showAnim: "clip",
			maxDate: "-2M"
        });
    });
	 
	 
	// Single Date Picker
	 $(function() {
       $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd", defaultDate:"<?php echo date('Y-m-d');?>", minDate: -30, maxDate: "+0D", showAnim: "clip" });
    });
	 
	  $(function() {
       $( "#datepicker1" ).datepicker({ dateFormat: "yy-mm-dd", defaultDate:"<?php echo date('Y-m-d');?>", minDate: -30, maxDate: "+0D", showAnim: "clip" });
    });
	 
	 //Single Date picker for leave request
	 $(function() {
       $( "#leavedatepicker" ).datepicker({dateFormat: "yy-mm-dd", defaultDate:"<?php echo date('Y-m-d');?>", minDate: +2, maxDate: "+8D", showAnim: "clip" });
    });
	 
	 //Single Date picker for attenance
	 $(function() {
       $( "#attendate" ).datepicker({dateFormat: "yy-mm-dd", defaultDate:"<?php echo date('Y-m-d');?>", maxDate: "+0D", showAnim: "clip" });
    });

	//month and year date picker with date
	 $(function() {
        $( "#dmpicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
			showAnim: "clip",
			dateFormat: "yy-mm-dd",
			yearRange: "1940:<?php echo date('Y');?>"
        });
		
	});
	 
	 
	//Month and Year alone withoput date Picker   
	$(function() {
	   $('#monthpicker').datepicker({
		 changeMonth: true,
		 changeYear: true,
		 dateFormat: 'MM yy',
		 showButtonPanel: true,
		 onClose: function() {
			var iMonth = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			var iYear = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			$(this).datepicker('setDate', new Date(iYear, iMonth, 1));
		 },
		   
		 beforeShow: function() {
		   if ((selDate = $(this).val()).length > 0) 
		   {
			  iYear = selDate.substring(selDate.length - 4, selDate.length);
			  iMonth = jQuery.inArray(selDate.substring(0, selDate.length - 5), $(this).datepicker('option', 'monthNames'));
			  $(this).datepicker('option', 'defaultDate', new Date(iYear, iMonth, 1));
			  $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
		   }
		}
	  });
	});

	//Message Dialog Box
	$(function() {
        $( "#dialog-message" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });
		//open popup dialog
	function openOffersDialog() 
	{
		$('#overlay').fadeIn('fast', function() {
			$('#boxpopup').css('display','block');
			$('#boxpopup').animate({'left':'30%'},500);
		});
	}
	//close popup dialog
	function closeOffersDialog(prospectElementID) 
	{
			
		$(function($) {
			$(document).ready(function() {
				$('#' + prospectElementID).css('position','absolute');
				$('#' + prospectElementID).animate({'left':'-100%'}, 500, function() {
					$('#' + prospectElementID).css('position','fixed');
					$('#' + prospectElementID).css('left','100%');
					$('#overlay').fadeOut('fast');
				});
			});
		});
	}
	
		//for message
	function show()
	{
		dhtmlx.message('Searching please wait...');
	}
	function save()
	{
		dhtmlx.message('Saving please wait...');
	}
	function del()
	{
		dhtmlx.message('Removing please wait...');
	}
	
	//for show tables
	function call()
	{
		if(document.getElementById('check').checked==true)
		{	
			document.getElementById('detail').style.display = 'none';
			document.getElementById('share_detail').style.display = 'none';
		}
		else
		{
			document.getElementById('detail').style.display='';
			document.getElementById('share_detail').style.display='';
		}
	}
	
	//for Clearing Text Box
	function clearText(field)
	{
		if (field.defaultValue == field.value) field.value = '';
		else if (field.value == '') field.value = field.defaultValue;
	}
	
	// For Checking Numeric or Not
	function checkNum(x)
	{
	  var s_len=x.value.length ;
	  var s_charcode = 0;
		for (var s_i=0;s_i<s_len;s_i++)
		{
		 s_charcode = x.value.charCodeAt(s_i);
		 if(!((s_charcode>=48 && s_charcode<=57)))
		  {
			 dhtmlx.alert({title:"Warning!!!", text:"Only Numeric Values Allowed"});
			  x.value='';
			 x.focus();
			return false;
		  }
		  
		}
		return true;
	}
