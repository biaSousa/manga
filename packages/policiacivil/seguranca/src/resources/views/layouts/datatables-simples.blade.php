{{--Tabela simples e clicável, sem paginação--}}
<link rel="stylesheet" type="text/css" href="{{url('datatables/datatables.min.css')}}">
<script src="{{url('datatables/datatables.min.js')}}"></script>
<script>
    $(document).ready(function() {
        oTable = $('#grid').DataTable({
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