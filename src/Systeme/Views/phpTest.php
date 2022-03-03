<?php
define('TEMPLATE', 'template-one');
define('PAGE', 'index');
?>

<?php ob_start(); ?>

<script>
    function getURL(url){
        link = "https://www." + url;
        document.getElementById('frame').src 
            = 'script?url='+encodeURIComponent(link);
    }
</script>

<button onclick="getURL('wibbo.org/client-nitro')">HCity</button>
<iframe id="frame" src=""></iframe>
<?php $contentOne = ob_get_clean(); ?>