{{--Tabela simples e clicável, sem paginação, deve ser usado apenas se datatables-simples já estiver em uso, pois não importa nenhum arquivo--}}
<script>
    $(document).ready(function() {
        <?php echo isset($id) ? "oTable_$id" : 'oTable' ?> = $('<?php echo isset($id) ? "#$id" : '#grid' ?>').DataTable({
            lengthChange: false,
            ordering: false,
            searching: false,
            select: true,
            paging: false,
            info: false,
            deferLoading: 0,
            language: {
                url: "{{url('datatables/pt-br.txt')}}",
                select: {
                    rows: {
                        _: "",
                        0: "",
                        1: ""
                    }
                }
            },
            "columns": [
                @foreach ( $colunas as $c)
                { "data": "{{$c}}" },
                @endforeach
            ]
        });
    });
</script>