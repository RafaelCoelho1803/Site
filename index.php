<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fazenda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('fundo.png');
            background-size: cover; /* ajusta o tamanho da imagem para cobrir a tela */
            background-position: center; /* posiciona a imagem no centro */
        }
        .login{
            width: 100%;
            height: 100vh;
            align-items: center;
            justify-content: center;
            display: flex;
        }
    </style>
<body>
    <div class="login"  >
        <div class="container">
            <div class="row" >
                <div class="col-lg-4 offset-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h3>Fazenda Alvorada</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-lg-4 offset-lg-4 jumbotron">
                                <form action="login.php" method="POST">
                                    <div>
                                        <div class="mb-3">
                                            <label>Usuário</label>
                                            <input type="text" name="usuario" class="form-control">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="mb-3">
                                            <label>Senha</label>
                                            <input type="password" name="senha" class="form-control">
                                        </div>
                                    </div> 
                                    <div>       
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-success">Enviar</button>
                                        </div>
                                    </div>    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>