<!DOCTYPE html>
<html>
    <head>
        <title>jQuery script to count the no. of characters in a textbox</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script>
            $(function () {
                //lets use the jQuery Keyboard Event to catch the text typed in the textbox 
                $('#txtbox').keyup(function () {
                    //.val() will give the text from the textbox and .length will give the number of characters
                    var txtlen = $(this).val().length;
                    //.replace used here to replace the space in the string and .length is to count the characters
                    //var txtlennospace = $(this).val().replace(/\s+/g, '').length;
                    //the below lines will display the results 
                    $('#txtbox_count').text(txtlen);
                    //$('#txtbox_count_no_space').text(txtlennospace);
 
                });
            });
        </script>
 
    </head>
    <body>
        <div style="padding-bottom: 10px;">jQuery - Realtime character counter</div>
        <div>
            Enter your text: <input style="padding: 7px;" maxlength="60" size="50" type="text" id="txtbox" />
            <p>No. of characters with space : <span id="txtbox_count"></span></p>
            <p>No. of characters without space : <span id="txtbox_count_no_space"></span></p>
        </div>
    </body>
 
</html>