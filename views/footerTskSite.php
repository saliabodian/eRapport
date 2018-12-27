<!--Footer-part-->

<div class="row-fluid">
    <div id="footer" class="span12"> 2017 &copy; eRapport By CDCL <a href="http://www.cdclux.com/en">www.cdclux.com</a> </div>
</div>

<!--end-Footer-part-->

<script src="js/tableToExcel.js"></script>
<script src="js/excanvas.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.ui.custom.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.flot.min.js"></script>
<script src="js/jquery.flot.resize.min.js"></script>
<script src="js/jquery.peity.min.js"></script>
<script src="js/fullcalendar.min.js"></script>
<script src="js/matrix.js"></script>
<script src="js/matrix.dashboard.js"></script>
<script src="js/jquery.gritter.min.js"></script>
<script src="js/matrix.interface.js"></script>
<script src="js/matrix.chat.js"></script>
<!--script src="js/jquery.validate.js"></script-->
<!--script src="js/matrix.form_validation.js"></script-->
<script src="js/jquery.wizard.js"></script>
<script src="js/jquery.uniform.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/matrix.popover.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/matrix.tables.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/prettify/r298/run_prettify.min.js"></script>
<script src="js/jquery.bootstrap-duallistbox.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">
    // This function is called from the pop-up menus to transfer to
    // a different page. Ignore if the value returned is a null string:
    function goPage (newURL) {

        // if url is empty, skip the menu dividers and reset the menu selection to default
        if (newURL != "") {

            // if url is "-", it is this page -- reset the menu:
            if (newURL == "-" ) {
                resetMenu();
            }
            // else, send page to designated URL
            else {
                document.location.href = newURL;
            }
        }
    }

    // resets the menu selection upon entry to this page:
    function resetMenu() {
        document.gomenu.selector.selectedIndex = 2;
    }
    var demo1 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox();
    $("#demoform").submit(function() {
        a
        //    alert($('[name="duallistbox_demo1[]"]').val());
        return false;
    });
    $( function() {
        $( ".datepicker" ).datepicker({
            // Affichage de la date au format voulu dans le datepicker
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            showWeek: true,
            firstDay: 1
        });
    } );


    $(document).ready(function(){
        $('#check_all').click(function(){
            if(this.checked){
                $('.checkbox_noyau').each(function(){
                    this.checked = true;
                });
            }else{
                $('.checkbox_noyau').each(function(){
                    this.checked = false;
                });
            }
        });

        $('.checkbox_noyaux').click(function(){
            if($('.checkbox_noyau:checked').length == $('.checkbox_noyau').length){
                $('#check_all').prop('checked',true);
            }else{
                $('#check_all').prop('checked',false);
            }
        });
    });


    $(document).ready(function(){
        $('#check_all_site').click(function(){
            if(this.checked){
                $('.checkbox_site').each(function(){
                    this.checked = true;
                });
            }else{
                $('.checkbox_site').each(function(){
                    this.checked = false;
                });
            }
        });

        $('.checkbox_site').click(function(){
            if($('.checkbox_site:checked').length == $('.checkbox_site').length){
                $('#check_all_site').prop('checked',true);
            }else{
                $('#check_all_site').prop('checked',false);
            }
        });
    });

    $(document).ready(function(){
        $('#check_all_abs').click(function(){
            if(this.checked){
                $('.checkbox_abs').each(function(){
                    this.checked = true;
                });
            }else{
                $('.checkbox_abs').each(function(){
                    this.checked = false;
                });
            }
        });

        $('.checkbox_abs').click(function(){
            if($('.checkbox_abs:checked').length == $('.checkbox_abs').length){
                $('#check_all_abs').prop('checked',true);
            }else{
                $('#check_all_abs').prop('checked',false);
            }
        });
    });

    $(document).ready(function(){
        $('#check_all_abs_hn').click(function(){
            if(this.checked){
                $('.checkbox_abs_hn').each(function(){
                    this.checked = true;
                });
            }else{
                $('.checkbox_abs_hn').each(function(){
                    this.checked = false;
                });
            }
        });

        $('.checkbox_abs_hn').click(function(){
            if($('.checkbox_abs:checked').length == $('.checkbox_abs_hn').length){
                $('#check_all_abs_hn').prop('checked',true);
            }else{
                $('#check_all_abs_hn').prop('checked',false);
            }
        });
    });

    $(document).ready(function(){
        $('#check_hn').click(function(){
            if(this.checked){
                $('.checkbox_hn').each(function(){
                    this.checked = true;
                });
            }else{
                $('.checkbox_hn').each(function(){
                    this.checked = false;
                });
            }
        });

        $('.checkbox_hn').click(function(){
            if($('.checkbox_hn:checked').length == $('.checkbox_hn').length){
                $('#check_hn').prop('checked',true);
            }else{
                $('#check_hn').prop('checked',false);
            }
        });
    });

    $(document).ready(function() {
        $('#addButton').on('click', function(e) {
            e.preventDefault();
            //    alert("ok");
            $('fieldset').removeClass('moreActions');
        });
    });

    $(document).ready(function() {
        $('#minusButton').on('click', function(e) {
            e.preventDefault();
            //alert("ok");
            $('fieldset').addClass('moreActions');
        });

    });

    /*$(document).ready(function(){
     var next = 1;
     $(".add-more").click(function(e){
     e.preventDefault();
     var addto = "#field" + next;
     var addRemove = "#field" + (next);
     next = next + 1;
     var newIn = '<input autocomplete="off" class="span11 input form-control" id="field' + next + '" name="field' + next + '" type="text">';
     var newInput = $(newIn);
     var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >-</button></div><div id="field">';
     var removeButton = $(removeBtn);
     $(addto).after(newInput);
     $(addRemove).after(removeButton);
     $("#field" + next).attr('data-source',$(addto).attr('data-source'));
     $("#count").val(next);

     $('.remove-me').click(function(e){
     e.preventDefault();
     var fieldNum = this.id.charAt(this.id.length-1);
     var fieldID = "#field" + fieldNum;
     $(this).remove();
     $(fieldID).remove();
     });
     });
     }); */

    $(document).ready(function(){
        var maxField = 15; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div class="control-group field_wrapper">' +
            '<div class="controls">' +
            '<input id="spaceBottom" type="text" class="span4" placeholder="Batiment" name="bat[]"/>' +
            '<a href="javascript:void(0);" class="remove_button"><i><img src="img/moins-mini.png"></i></a></div></div>'; //New input field html
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });


    function getId(val,chantierId){
        //test du javascript
        //alert("ok");
        //implémentation de la fonction AJAX
        $.ajax({
            type : "POST",
            url : "getTache.php",
            data : "tsk_type_id="+val+"&chantierId="+$('#chantier_id').val(),
            success : function(data){
                $(".task").html(data);
            }
        });
    }
    function getId2(val,chantierId){
        //test du javascript
        //alert("ok");
        //implémentation de la fonction AJAX
        $.ajax({
            type : "POST",
            url : "getTache.php",
            data : "tsk_type_id="+val+"&chantierId="+$('#chantier_id').val(),
            success : function(data){
                $(".task2").html(data);
            }
        });
    }

    function getId3(val,chantierId){
        //test du javascript
        //alert("ok");
        //implémentation de la fonction AJAX
        $.ajax({
            type : "POST",
            url : "getTache.php",
            data : "tsk_type_id="+val+"&chantierId="+$('#chantier_id').val(),
            success : function(data){
                $(".task3").html(data);
            }
        });
    }

    function getId4(val,chantierId){
        //test du javascript
        //alert("ok");
        //implémentation de la fonction AJAX
        $.ajax({
            type : "POST",
            url : "getTache.php",
            data : "tsk_type_id="+val+"&chantierId="+$('#chantier_id').val(),
            success : function(data){
                $(".task4").html(data);
            }
        });
    }

    function getId5(val,chantierId){
        //test du javascript
        //alert("ok");
        //implémentation de la fonction AJAX
        $.ajax({
            type : "POST",
            url : "getTache.php",
            data : "tsk_type_id="+val+"&chantierId="+$('#chantier_id').val(),
            success : function(data){
                $(".task5").html(data);
            }
        });
    }


    function getId6(val,chantierId) {
        //test du javascript
        //alert("ok");
        //implémentation de la fonction AJAX
        $.ajax({
            type: "POST",
            url: "getTache.php",
            data: "tsk_type_id=" +val+"&chantierId="+$('#chantier_id').val(),
            success: function (data) {
                $(".task6").html(data);
            }
        });
    }

    function getChantierId(val) {
        //test du javascript
        //alert("ok");
        //implémentation de la fonction AJAX
        $.ajax({
            type: "POST",
            url: "getOuvrier.php",
            data: "chantier_id=" + val,
            success: function (data) {
                $(".fullname").html(data);
            }
        });
    }

    function getFullname(val) {
        //test du javascript
        //alert("ok");
        //implémentation de la fonction AJAX
        $.ajax({
            type: "POST",
            url: "getOuvrierTache.php",
            data: "fullname=" + val,
            success: function (data) {
                $(".tache_ouvrier").html(data);
            }
        });
    }

    function getChantierId2(val) {
        //test du javascript
        //alert("ok");
        //implémentation de la fonction AJAX
        $.ajax({
            type: "POST",
            url: "getChefDequipe.php",
            data: "chantier_id=" + val,
            success: function (data) {
                $(".chef_dequipe").html(data);
            }
        });
    }


    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    $(document).ready(function(){
        $("#myInputGeneratedReport").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTableGeneratedReport tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });


    $(document).ready(function(){
        $("#myInputSubmittedReport").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTableSubmittedReport tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    $(document).ready(function(){
        $("#myInputValidatedReport").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTableValidatedReport tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    $(document).ready(function(){
        $("#myInputMissingAnomaly").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTableMissingAnomaly tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    $(document).ready(function(){
        $("#myInputHourAnomaly").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTableHourAnomaly tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    $(document).ready(function(){
        $("#myInputChantierWithoutItp").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTableChantierWithoutItp tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    $(document).ready(function(){
        $("#myInputChantierWithItp").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTableChantierWithItp tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    $(document).ready(function() {
        $('#table').DataTable( {
            "pagingType": "full_numbers"
        } );
    } );
    /*

     Gestion de l'ajout dynamique des lignes
     je mets cette option en suspens à cause d'un bug que je n'arrive pas à corriger
     $(document).ready(function() {

     $(".add-more").click(function(){
     var html = $(".copy").html();
     $(".tasks").after(html);
     });

     $("body").on("click",".remove",function(){
     $(this).parents(".addRow").remove();
     });

     });

     */


    function printErapport(){

        var nb = document.getElementById("nb").value;
        //    var id_rapport_1 = document.getElementById("id_rapport_1").value;

        //    alert( nb);
        //    alert( id_rapport_1);

        for(var i=0;i<nb ;i++){
            var randomnumber = Math.floor((Math.random()*100)+1);
            var id_rapport = document.getElementById("id_rapport_"+i).value;
            //    alert(id_rapport);
            var date = document.getElementById("date_"+i).value;
            //    alert(date);
            var rapport_type = document.getElementById("rapport_type_"+i).value;
            var user_id = document.getElementById("user_id_"+i).value;
            var username = document.getElementById("username_"+i).value;
            var firstname = document.getElementById("firstname_"+i).value;
            var lastname = document.getElementById("lastname_"+i).value;
            var chantier_id = document.getElementById("chantier_id_"+i).value;
            var code = document.getElementById("code_"+i).value;
            var nom = document.getElementById("nom_"+i).value;
            var submitted = document.getElementById("submitted_"+i).value;
            var validated = document.getElementById("validated_"+i).value;
            var generated_by = document.getElementById("generated_by_"+i).value;
            //    alert(id_rapport);
            window.open("eRapportShowPrint.php?rapport_id="+id_rapport+"&rapport_type="+rapport_type+"&chef_dequipe_id="+user_id+"&chef_dequipe_matricule="+username+"&date_generation="+date+"&chantier_id="+chantier_id+"&chantier_code="+code+"&validated="+validated+"&submitted="+submitted, id_rapport);
            window.close();
        }

        //    window.open("eRapportShowPrint.php?rapport_id="+id_rapport+"&rapport_type="+rapport_type+"&chef_dequipe_id="+user_id+"&chef_dequipe_matricule="+username+"&date_generation="+date+"&chantier_id="+chantier_id+"&chantier_code="+code+"&validated="+validated+"&submitted="+submitted+".pdf");
        //    window.open("http://www.google.lu");
        //    window.open("http://www.seneweb.com");
    }

    // Export to excell TEST

    function fnExcelReport()
    {
        var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
        var textRange; var j=0;
        tab = document.getElementById('headerTable'); // id of table

        for(j = 0 ; j < tab.rows.length ; j++)
        {
            tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
            //tab_text=tab_text+"</tr>";
        }

        tab_text=tab_text+"</table>";
        tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
        tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
        tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
            txtArea1.document.open("txt/html","replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
        }
        else                 //other browser not tested on IE 11
            sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

        return (sa);
    }
</script>
</body>
</html>
