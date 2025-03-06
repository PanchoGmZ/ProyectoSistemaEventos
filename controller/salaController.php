<?php

require "util.php";
require "../model/sala.php";

class salaController
{
    function salvar()
    {
        if(isset($_POST['salvar']))
        {
            $nome = Util::clearparam($_POST['nome']);
            $id = Util::clearparam($_POST['id']);

            $sala = new sala();
            $sala->salvar($id, $nome);
            header("Location: sala_list.php");
            exit();
        }
    }
    
    function excluir()
    {
        if(isset($_POST['excluir']))
        {
            $id = Util::clearparam($_POST['id']);
            
            $sala = new sala();
            $sala->excluir($id);
        
            header("Location: sala_list.php");
            exit();
        }
    }
    
    function abrir()
    {
        if(isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $sala = new sala();
            return $sala->abrir($_GET['id']);
        }   
    }
    
    // Listagem de salas
    function listarcontroller()
    {
        $sala = new sala();
        $linhas = $sala->listar();
        
        $tabela = '';
        foreach($linhas as $linha)
        {
            $tabela .= '<tr>
                            <td>'.$linha['id'].'</td>
                            <td><a href="sala_form.php?id='.$linha['id'].'">'.$linha['nome'].'</a></td>
                            <td>
                                <a href="sala_form.php?id='.$linha['id'].'">Editar</a> |
                                <form action="sala_list.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="'.$linha['id'].'">
                                    <input type="submit" name="excluir" value="Eliminar">
                                </form>
                            </td>
                        </tr>';
        }
        
        return $tabela;
    }

    // Editar sala
    function editar()
    {
        if(isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $id = $_GET['id'];
            $sala = new sala();
            return $sala->abrir($id);
        }
    }
}

?>
