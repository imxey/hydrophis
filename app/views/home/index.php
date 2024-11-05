<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <script src="jquery/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script type="text/javascript">
        // $(document).ready(function() {
            
        //     setInterval(function (){
        //         $('#ph').attr('src', 'chart.php?' + new Date().getTime());
        //     }, 500);
            
        // });
        $(document).ready(function() {
            setInterval(function (){
                $("#ph").load("ph.php");
                $(".status").load("status.php", function(response) {
            if (response.trim() !== "pH air normal") {
                $(".status").removeClass("btn-primary custom-button-primary").addClass("btn-danger custom-btn-danger");
            } else {
                $(".status").removeClass("btn-danger custom-btn-danger").addClass("btn-primary custom-button-primary");
            }
        });
            }, 500);
            });
    </script>
</head>
<body >
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center" style="background-color:#f4f4f4;">
        <div class="card text-center" style="width : 50%;">
            <div class="card-header">
                Hydrophis
            </div>
            <div class="card-body">
                <h5 class="card-title">Controlling pH Air</h5>
                <!-- <iframe id="ph" src="chart.php"></iframe> -->
                <h1 id="ph"></h1>
                <div class="btn btn-primary custom-button-primary status" >pH Rendah</div>
            </div>
        </div>
    </div>    
</body>

</html>
<style>
    .custom-button-primary:hover{
        background-color: #0d6efd;  
        color: white;  
        cursor: default;  
    }
    .custom-btn-danger:hover{
        background-color: #dc3545;  
        color: white; 
        cursor: default;  
    }
</style>
