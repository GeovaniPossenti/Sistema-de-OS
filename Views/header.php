<header class="p-3 text-white header">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <img src="../Source/img/computador-pessoal.png" alt="" width="40px" height="40px" title="Logo">
            </a>
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0" style="margin-left: 20px;">
                <li><a href="os.php" class="nav-link px-2 <?php echo @$corTituloOS; ?>" title="Página com a lista de Ordens de Serviços"><i class="fas fa-clipboard"></i> Ordens de Serviço</a></li>
                <li><a href="clientes.php" class="nav-link px-2 <?php echo @$corTituloClientes; ?>" title="Página com a lista de Clientes"><i class="fas fa-user-friends"></i> Lista de Clientes</a></li>
                <li><a href="#" class="nav-link px-2 text-secondary"></a></li>
            </ul>
            <div class="text-end">
                <a href="../App/Controls/control_logout.php"><button type="button" class="btn btn-danger" title="Logout"><i class="fas fa-sign-out-alt"></i> Sair</button></a>
            </div>
        </div>
    </div>
</header>