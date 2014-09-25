<?php
//mysql -u -pEuR6szv8 -hsql16.cpt3.host-h.net thoribm_db2
?>
<script>
    var r = function() {
        var s = 0; var n;
        for(n = 0; n < 1000; ++n){(n%3===0||n%5==0)?s=s+n:0;}
        document.write(s.toString());
    }
    r();
</script>