<?php
	session_start();
	if(empty($_SESSION) ){
		print "<script>location.href='index.php';</script>";
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fazenda</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
    .Button-column {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
    }

    .Button-column button {
        font-size: 24px;
        height: 160px;
        width: 190px;
        margin: 4%;
    }

    .material-symbols-outlined {
        font-size: 70px;
    }


</style>

    
</head>
<body >
    <div class="Top-side">
        <div class="pos-f-t">
        <div class="collapse" id="navbarToggleExternalContent">
            <div class="bg-dark p-4">
            <h5 class="text-white h4">Fazenda Alvorada</h5>
            </div>
        </div>
        <nav class="navbar navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div style="color: white;">
                <?php 
                print "Olá, ".$_SESSION["nome"] ;
                ?>
            </div>
            <?php 
            print "<a href='logout.php' class='btn btn-danger'>Sair </a> ";
            ?>
        </nav>
        </div>
    </div>
    <div class="Down-side">
        <div class="container">
            <div class="row">
                <div class="col-md-auto">
                    <div class="Button-column">
                        <button onclick="redirectToPesagem()" type="button" class="btn btn-outline-success">
                            <span class="material-symbols-outlined">psychiatry</span>
                            <div class="Palavra">PESAGEM</div>
                        </button>
                        <button onclick="redirectToFrete()" type="button" class="btn btn-outline-success">
                            <span class="material-symbols-outlined">local_shipping</span>
                            <div class="Palavra">FRETE</div>
                        </button>
                        <button onclick="redirectToResultado()" type="button" class="btn btn-outline-success">
                            <span class="material-symbols-outlined">bar_chart_4_bars</span>
                            <div class="Palavra">Resultados</div>
                        </button>
                    </div>
                </div>
                <div class="col-md ">
                    <div class="Button-column">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


    
    
        <script>
            function redirectToPesagem() {
            window.location.href = 'pesagem.php';
            }
        </script>

        <script>
            function redirectToDesconto() {
            window.location.href = 'desconto.php';
            }
        </script>
    
        <script>
            function redirectToFrete() {
            window.location.href = 'frete.php';
            }
        </script> 

        <script>
            function redirectToResultado() {
            window.location.href = 'resultados.php';
            }
        </script> 

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
</body>

