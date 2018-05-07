$(document).ready(function(){
    $(".keahlian_baru").hide();
    
    $(document).on('click', '.keahlian' , function() {
        if (this.value > 0){ 
            $(".keahlian_baru").hide();           
        } else {
            $(".keahlian_baru").show();           
        }       
    })
    
});