{{--Tabela simples e clicável, sem paginação--}}
<link rel="stylesheet" type="text/css" href="{{ asset('datatables/datatables.min.css') }}">
<script src="{{ asset('datatables/datatables.min.js')}}"></script>
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
            // initComplete: function() {
            //     if(typeof gridCarregado === 'function') {
            //         gridCarregado();
            //     }
            // },
            language: {
                url: "{{ asset('datatables/pt-br.txt') }}",
                select: {
                    rows: {
                        _: "",
                        0: "",
                        1: ""
                    }
                }
            },
            "columns": [
                @foreach($colunas as $c) {
                    "data": "{{$c}}"
                },
                @endforeach
            ]
        });

        <?php echo isset($id) ? "oTable_{$id}_CRUD" : 'oTable_CRUD' ?> = {
            create: function(o) {
                <?php echo isset($id) ? "oTable_$id" : 'oTable' ?>.row.add(o).draw(false);
            },
            read: function() {
                return <?php echo isset($id) ? "oTable_$id" : 'oTable' ?>.row('.selected').data();
            },
            update: function(o) {
                let index = <?php echo isset($id) ? "oTable_$id" : 'oTable' ?>.rows('.selected').indexes()[0];
                $('<?php echo isset($id) ? "#$id" : '#grid' ?>').dataTable().fnUpdate(o, index);
            },
            delete: function(m, cb) {
                let linha = <?php echo isset($id) ? "oTable_$id" : 'oTable' ?>.rows('.selected').indexes()[0];
                if (typeof linha !== 'undefined') {
                    if (confirm(m)) {
                        let id = <?php echo isset($id) ? "oTable_$id" : 'oTable' ?>.row(linha).id();
                        <?php echo isset($id) ? "oTable_$id" : 'oTable' ?>.row(linha).remove().draw();
                        if (typeof cb === 'function') {
                            cb(id);
                        }
                    }
                } else {
                    alert('Selecione uma linha');
                }
            },
        };
    });
</script>