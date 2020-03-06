{{--Tabela padrão usada na maioria das telas com paginação, download de conteúdo via ajax e habilita e desabilita botões--}}
<link rel="stylesheet" type="text/css" href="{{url('datatables/datatables.min.css')}}">
<script src="{{url('datatables/datatables.min.js')}}"></script>
<script>
    $(document).ready(function() {
        oTable = $('#grid').DataTable({
            lengthChange: false,
            ordering: false,
            searching: false,
            processing: true,
            serverSide: true,
            // createdRow: function(row, data, index) {
            //
            //     row.addEventListener('click', function(e) {
            //         console.log(row.classList);
            //     });
            // },
            select: {
                style: 'single'
            },
            @if(isset($pageLength))
            pageLength: <?php echo $pageLength ?>, //Opcional.Padrão 10 configurado na classe de Paginação            
            @endif
            deferLoading: <?= isset($carregamento_inicial) ? 'null' : 0 ?>,
            rowCallback: function(row, data, index) {
                if (typeof rowCallback === 'function') {
                    rowCallback(row, data, index);
                }
            },
            language: {
                url: "{{ asset('datatables/pt-br.txt')}}",
                select: {
                    rows: {
                        _: "",
                        0: "",
                        1: ""
                    }
                }
            },
            ajax: {
                url: document.getElementById('form').action,
                data: function(d) {
                    $('.botao').attr('disabled', true);
                    oTable.rows().deselect();
                    $.each($('#form').serializeArray(), function(index, value) {
                        d[value.name] = value.value;
                    });
                    d['page'] = ((d.start / d.length) + 1);
                },
                error: function(e) {
                    if (e.status == 401) {
                        alert('Sessão expirada');
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

        $('#grid tbody').on('click', 'tr', function() {
            var isSelecionado = this.classList.contains('selected');
            if (isSelecionado) {
                $('.botao').attr('disabled', true);
            } else {
                $('.botao').attr('disabled', false);
            }

            if (typeof linhasGridCallback === 'function') {
                linhasGridCallback(isSelecionado, $(this).children());
            }
        });

        <?php echo isset($id) ? "oTable_{$id}_CRUD" : 'oTable_CRUD' ?> = {
            create: function(o) {
                <?php echo isset($id) ? "oTable_$id" : 'oTable' ?>.row.add(o).draw(false);
            },
            read: function() {
                return <?php echo isset($id) ? "oTable_$id" : 'oTable' ?>.rows('.selected').data()[0];
            },
            update: function(o) {
                let index = <?php echo isset($id) ? "oTable_$id" : 'oTable' ?>.rows('.selected').indexes()[0];
                $('<?php echo isset($id) ? "#$id" : '#grid' ?>').dataTable().fnUpdate(o, index);
            },

            delete: function(m, cb) {
                let linha = <?php echo isset($id) ? "oTable_$id" : 'oTable' ?>.rows('.selected').data()[0];
                if (typeof linha !== 'undefined') {
                    if (confirm(m)) {
                        <?php echo isset($id) ? "oTable_$id" : 'oTable' ?>.row(linha).remove().draw();
                        if (typeof cb === 'function') {
                            cb();
                        }
                    }
                } else {
                    alert('Selecione uma linha');
                }
            }
        };
    });
</script>