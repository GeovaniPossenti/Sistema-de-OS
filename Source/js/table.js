$(document).ready( function () {
    $('#tabelaDados').DataTable({
        lengthMenu: [25, 50, 75, 100],
        language: {
            "lengthMenu": "Exibir _MENU_ linhas por página",
            "zeroRecords": "Nada encontrado!",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum registro disponível",
            "infoFiltered": "(filtrado de _MAX_ registros totais)",
            "emptyTable": "Não há dados para exibir!",
            "loadingRecords": "Carregando...",
            "processing": "Em processamento...",
            "search": "Procurar:",
            "paginate": {
                "first": "Primeiro",
                "last": "Último",
                "next": "Próximo",
                "previous": "Anterior"
            },
        },
    });
});