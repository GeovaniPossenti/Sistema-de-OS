<?php 
    header('charset=ISO-8859-1');
    date_default_timezone_set('America/Sao_Paulo');
    //Starto a sessão e pego o SESSION da váriavel que diz se eu estou logado ou não.
    session_start();
    $login = $_SESSION['logged_in'];   
    
    //Controle de acesso, só é possível acessar os.php/clientes.php/relatorio.php com a session de logged_in != de vazio.
    if($login != true){
        $_SESSION['alerts'] = 'forcedEntry';
        header('Location: ../index.php');
    }
    
    //Include da conexão com o banco.
    include_once '../model/conexao.php';
    $conn = new Conexao;
    $con = $conn->conectar();

    $id_os = $_GET['id'];

    //Select que pega os dados pra preencher a tabela de OS.
    $SelectRelatorio = "SELECT `p`.`id_os_pendente`, `p`.`nome_equipamento`, `p`.`descricao_defeito`, `p`.`descricao_reparo`,`p`.`data_recebimento`, `p`.`data_entrega_cliente`, `p`.`valor_reparo`, `u`.`nome_cliente` FROM `os_pendente` `P` join `clientes` `U` on (`P`.`id_cliente` = `U`.`id_cliente`) WHERE `id_os_pendente` = '$id_os'";
    $stmt = $con->prepare($SelectRelatorio);
    $stmt->execute();
    $arraySelectOS = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Relatório OS</title>
    </head>
    <body>
        <?php 
			ob_start();
			require_once("../tools/lib/fpdf/fpdf.php");
			$pdf = new FPDF("P","mm","A5");
                     
            $pdf->AddPage();
            
            //Add new font.
            $pdf->AddFont('OpenSans','','OpenSans-Regular.php');
            $pdf->AddFont('OpenSansLight','','OpenSans-Light.php');

            //Header ?
            $pdf->SetFont('OpenSans','',28);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFillColor(255,255,255);
            
            //Número da ordem de serviço.
            $pdf->SetFont('OpenSansLight','',10);
            $pdf->SetY(1); $pdf->SetX(15);
            $pdf->Cell(18,8, utf8_decode("Ordem de serviço N° $id_os"),0,0,"C","false");

            //Logo da página.
            $pdf->Image("../tools/img/computador-pessoal.png",123,5,20,0);

            //Titulo.
            $pdf->SetFont('OpenSansLight','', 23);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(75, 33, utf8_decode("Ordem de serviço") ,0,1,'C');

            //Informações sobre a empresa/técnico.
            $pdf->SetFont('OpenSansLight','',8);
            $pdf->SetY(29); $pdf->SetX(18);
            $pdf->Cell(25,8, utf8_decode("Empresa: Matrix Informática"),0,0,"C","false");

            
            //Linha que separa o header do section.
            $pdf->SetFillColor(0,0,0);
            $pdf->SetY(35);
            $pdf->Cell(129,0,'',0,1,'C','true');

            //Titulo do section. 
            $pdf->SetFont('OpenSansLight','',20);
            $pdf->SetY(42); $pdf->SetX(12);
            $pdf->Cell(0,0,utf8_decode("Informações"),0,1,'C');

            //Linhas da tabela
            //Dados colocados em linhas
            $pdf->SetY(48); $pdf->SetX(5);
            $pdf->SetFont('OpenSansLight','',12);
            $pdf->SetFillColor(240,248,255);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(220,220,220); //Color da borda dos cells.
            $pdf->Cell(50,10, utf8_decode('Nome do cliente:'),'B',0,"R",true);
            $pdf->SetFillColor(245,245,245);
            $pdf->Cell(90,10, utf8_decode($arraySelectOS['nome_cliente']),'B',0,"L",true);

            $pdf->SetY(58.1); $pdf->SetX(5);
            $pdf->SetFillColor(240,248,255);
            $pdf->Cell(50,10, utf8_decode('Nome do equipamento:'),'B',0,"R",true);
            $pdf->SetFillColor(245,245,245);
            $pdf->Cell(90,10, utf8_decode($arraySelectOS['nome_equipamento']),'B',0,"L",true);

            $pdf->SetY(68.2); $pdf->SetX(5);
            $pdf->SetFillColor(240,248,255);
            $pdf->Cell(50,10, utf8_decode('Data de recebimento:'),'B',0,"R",true);
            $pdf->SetFillColor(245,245,245);
            $pdf->Cell(90,10, utf8_decode(inverteData($arraySelectOS['data_recebimento'])),'B',0,"L",true);

            $pdf->SetY(78.4); $pdf->SetX(5);
            $pdf->SetFillColor(240,248,255);
            $pdf->Cell(50,10, utf8_decode('Data de devolução:'),'B',0,"R",true);
            $pdf->SetFillColor(245,245,245);
            $pdf->Cell(90,10, utf8_decode(inverteData($arraySelectOS['data_entrega_cliente'])),'B',0,"L",true);

            $pdf->SetY(88.5); $pdf->SetX(5);
            $pdf->SetFillColor(240,248,255);
            $pdf->Cell(50,10, utf8_decode('Valor cobrado:'),'B',0,"R",true);
            $pdf->SetFillColor(245,245,245);
            $pdf->Cell(90,10, utf8_decode("R$ ".str_replace('.', ',', ($arraySelectOS['valor_reparo']))),'B',0,"L",true);

            //Descrições das Ordens de serviço.
            $pdf->SetY(98.6); $pdf->SetX(5);
            $pdf->SetFillColor(240,248,255);
            $pdf->Cell(50,35, utf8_decode('Descrição do defeito:'),'B',0,"R","true");
            $pdf->SetFillColor(245,245,245);
            $pdf->MultiCell(90, 5, utf8_decode($arraySelectOS['descricao_defeito']),'B','J',true);

            //Descrições das Ordens de serviço.
            $pdf->SetY(133.8); $pdf->SetX(5);
            $pdf->SetFillColor(240,248,255);
            $pdf->Cell(50,35, utf8_decode('Descrição do reparo:'),'B',0,"R","true");
            $pdf->SetFillColor(245,245,245);
            $pdf->MultiCell(90, 5, utf8_decode($arraySelectOS['descricao_reparo']), 'B','J',true);

            //Aqui eu exibo a data e hora atual.
            $pdf->SetFont('OpenSansLight','',8);
            $pdf->SetFillColor(255,255,255);
            $data_atual = date('d/m/Y - H:i:s');
            $pdf->SetY(171); $pdf->SetX(88);
            $pdf->Cell(55,0, utf8_decode("Documento gerado em: $data_atual"),0,0,"C","false");


            //Aqui eu escolho o tipo de arquivo, e o name dele.
            $pdf->Output("relatorio_os_id_".$id_os.".pdf","I");
        ?>
    </body>
</html>