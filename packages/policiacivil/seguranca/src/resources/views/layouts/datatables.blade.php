{{--Tabela padrão usada na maioria das telas com paginação, download de conteúdo via ajax e habilita e desabilita botões--}}
<link rel="stylesheet" type="text/css" href="{{url('datatables/datatables.min.css')}}">
<script src="{{url('datatables/datatables.min.js')}}"></script>
<script>
    $(document).ready(function() {
        oTable = $('#grid').DataTable({
            lengthChange: false,
            ordering: false,
            searching: false,
            select: true,
            processing: true,
            serverSide: true,
            select: {
                style: 'single'
            },
            @if(isset($pageLength))
            pageLength: <?php echo $pageLength ?>,{{--Opcional. Padrão 10 configurado na classe de Paginação--}}
            @endif
            deferLoading: 0,
            rowCallback: function(row, data, index) {
                if (typeof rowCallback === 'function') {
                    rowCallback(row, data, index);
                }
            },
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
            ajax: {
                url: document.getElementById('form').action,
                data: function(d) {
                    $('.botao').attr('disabled', true);
                    oTable.rows().deselect();
                    $.each($('#form').serializeArray(), function(index, value) {
                        d[value.name] = value.value;
                    });
                    d['page'] = ((d.start/d.length)+1);
                },
                error: function(e) {
                    if(e.status == 401) {
                        alert('Sessão expirada');
                    }
                }
            },
            "columns": [
                @foreach ( $colunas as $c)
                { "data": "{{$c}}" },
                @endforeach
            ]
        });

        $('#grid tbody').on( 'click', 'tr', function () {

            if ( $(this).hasClass('selected') ) {
                $('.botao').attr('disabled', false);
            }
            else {
                $('.botao').attr('disabled', true);
            }
            if(typeof linhasGridCallback === 'function') {
                linhasGridCallback();
            }

        });
    });
</script>