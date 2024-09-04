// For password validation //

var minLength = 8;

var maxLength = 16;

$(document).ready(function(){

    $('#password').on('change', function(){

        var char = $(this).val();

        var charLength = $(this).val().length;

		if(charLength < minLength){

            $('#wm2').text('Length is short, minimum '+minLength+' char required.');

			$('#wm2').css("color", "red");

			$(this).val('');

			$(this).focus();

        }else if(charLength > maxLength){

            $('#wm2').text('Length is not valid, maximum '+maxLength+' char allowed.');

			$('#wm2').css("color", "red");

			$(this).val('');

			$(this).focus();

        }else{

            $('#wm2').text('');

        }

    });

});

// For password validation //



// For mobile number validation //

$(".mobile").keydown(function(event){ 

k = event.which;

if ((k >= 96 && k <= 105) || k == 8 || k == 9 || k >=37 && k<=40 || (k >= 46 && k <= 57)) 

{ 

	if ($(this).val().length == 10) 

	{ 

		if (k == 8 || k == 9 || k >=37 && k<=40 || k==46) 

		{

		return true;

		} 

		else 

		{ 

			event.preventDefault(); return false; 

		}

	}	

}

else

{ event.preventDefault(); return false; } 

});



var mobLength = 10;

$(document).ready(function(){

    $('.mobile').on('change', function(){

		var mLength = $(this).val().length;

		if(mLength < mobLength)

		{

		$(this).next(".mobile_error").html("Please enter "+mobLength+" digit mobile number.");

		$(this).next(".mobile_error").css("color", "red");

		$(this).val('');

		$(this).focus();

        }

		else{

		$(this).next(".mobile_error").text('');	

        }

    });

});

// For mobile number validation //



//For aadhar no validation//

$(".aadhar").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || k == 9 || k >=37 && k<=40 || (k >= 46 && k <= 57)) { if ($(this).val().length == 12	) { if (k == 8 || k == 9 || k >=37 && k<=40 || k==46) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });



var adLength = 12;

$(document).ready(function(){

    $('.aadhar').on('change', function(){

		var mLength = $(this).val().length;

		if(mLength < adLength)

		{

		$(this).next(".aadhar_error").html("Please enter "+adLength+" digit aadhar number.");

		$(this).next(".aadhar_error").css("color", "red");

		$(this).val('');

		$(this).focus();

        }

		else{

		$(this).next(".aadhar_error").text('');	

        }

    });

});

//For aadhar no validation//


//For student registration number validation//

function registration() 											

	{
	var rno=$("#txt_uname").val();
	
	// console.log(rno);

	var dataString={'rno':rno};

				$.ajax({  

				 url:"view_ajax_register.php",  

				 method:"POST",  

				 data:dataString, 

				 success:function(data)

				 {  
				 	var result=JSON.parse($.trim(data));
				 	
				 if(result.type=='Already') 		
				 {
					 	console.log('matched');
				 	// alert(123);
						$('#res1').text(result.message);
						// $('#res1').html("This Register Number is Already Exists.");

						$("#txt_uname").val('');

						$("#txt_uname").focus();

				 }else{

					$('#res1').html('');
					// console.log('not matched');

				 }

			 

				 }  

			});

	}		

//For student registration number validation//

//For staff id validation//

function chkstafid() 													

	{

	var sid=$("#staffid").val();

	var dataString={'sid':sid};

				$.ajax({  

				 url:"view_ajax_staffid.php",  

				 method:"POST",  

			     data:dataString, 

				 success:function(data){  
				 var result=JSON.parse($.trim(data));
				 if(result.type=='Already') 		
				 {

					$('#res1').html(result.message);

					$("#staffid").val('');

					$("#staffid").focus();

				 }else{

					$('#res1').html('');

				 }

				 }  

			});

	}		

//For staff id validation//