<?php

require "util.php";
require "../model/usuario.php";

class UsuarioController
{
    // Guardar usuario
    function salvar()
    {
        if (isset($_POST['salvar']))
        {
            $nome = Util::clearparam($_POST['nome']);
            $email = Util::clearparam($_POST['email']);
            $senha = Util::clearparam($_POST['senha']);
            $id = Util::clearparam($_POST['id']);

            if (strlen($senha) == 32) {
                $senha = '';    
            }

            $usuario = new Usuario();
            $usuario->salvar($id, $nome, $email, $senha);
            header("Location: usuario_list.php");
            exit();
        }
    }

    // Eliminar usuario
    function excluir()
    {
        if (isset($_POST['excluir']))
        {
            $id = Util::clearparam($_POST['id']);
            $usuario = new Usuario();
            $usuario->excluir($id);
            header("Location: usuario_list.php");
            exit();
        }
    }

    // Abrir usuario para edición
    function abrir()
    {
        if (isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $usuario = new Usuario();
            return $usuario->abrir($_GET['id']);
        }    
    }

    // Listar usuarios
    function listarcontroller()
    {
        $usuario = new Usuario();
        $linhas = $usuario->listar();
        
        $tabela = '';
        foreach ($linhas as $linha) {
            $tabela .= '<tr>
                            <td>'.$linha['id'].'</td>
                            <td><a href="usuario_form.php?id='.$linha['id'].'">'.$linha['nome'].'</a></td>
                            <td>'.$linha['email'].'</td>
                            <td>
                                <a href="usuario_form.php?id='.$linha['id'].'" class="btn1">Editar</a>
                                <form action="usuario_form.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="'.$linha['id'].'" />
                                    <input type="submit" name="excluir" value="Eliminar" class="btn1" onclick="return confirm(\'¿Estás seguro de que quieres eliminar este usuario?\')" />
                                </form>
                            </td>
                        </tr>';
        }
        
        return $tabela;
    }
    

    // Función de autenticar
    function autenticarController()
    {
        if (isset($_POST['email']) && isset($_POST['senha']))
        {
            $senha = md5($_POST['senha']);
            $email = Util::clearparam($_POST['email']);
            $usuario = new Usuario();
            $row = $usuario->autenticar($email, $senha);

            if (isset($row[0]['id']))
            {
                session_start();
                $_SESSION['user_id'] = $row[0]['id'];
                header("Location: index.php");
                exit();
            }
            else
            {
                return "E-mail y contraseña no son validos";
            }
        }
        return ''; // Si no se hace nada
    }
}
?>
