@php
    use SQ10\helpers\Util as Util;
@endphp

@if(count($procesosBuzon) > 0)
    <input type="hidden" value="0" id="remover">
    <table id="inbox-table" class="table table-striped table-hover">
        <tbody>
            @foreach($procesosBuzon as $key => $procesoBuzon)
                <tr id="{{$procesoBuzon['idEstadoEtapa']."-".$procesoBuzon['idTipoProcesos']."-".$procesoBuzon['juritiposestados_idTipoEstado']}}" class="fila {{$procesoBuzon['leidoEstado'] == 0 ? 'noLeido' : '' }}">
                    @php
                        $idEstados[$key] = $procesoBuzon['idEstadoEtapa'];
                    @endphp
                    <td style="width:8%">
                        {{$procesoBuzon['idRadicado']."-".$procesoBuzon['vigenciaRadicado']}} 
                    </td>
                    <td style="width:8%">
                        {{Util::formatearFecha($procesoBuzon['fechaInicioEstado'])}}
                    </td>
                    <td>
                        <span class="text-muted">{{$procesoBuzon['nombreTipoProceso']}}</span> 
                    </td>
                    <td>
                        {{$procesoBuzon['codigoProceso']}}
                    </td>
                    <td>
                        <span class="text-muted">{{$procesoBuzon['nombreMedioControl']}}</span>
                    </td>
                    <td>
                        {{$procesoBuzon['nombreJuzgado']}}
                    </td>
                    <td>
                        {{Util::dependenciaDemandada($procesoBuzon['vigenciaRadicado'], $procesoBuzon['idRadicado'], $procesoBuzon['idTipoProcesos'])}}
                    </td>
                    <td>
                        {{Util::traerSolicitanteBuzon($procesoBuzon['vigenciaRadicado'], $procesoBuzon['idRadicado'])}}
                    </td>   

                    @if($procesoBuzon['buzonEspecial'] == 1)
                        <td class="inbox-data-date hidden-xs">
                            <div>
                                <td style="width:5%">
                                    <button class="btn btn-xs btn-succes btn-rounded" onclick="trasladarMisProcesos({{$procesoBuzon['idEstadoEtapa']}})"><i class="fa fa-edit"></i> Mis Procesos </button>
                                </td> 
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p class="alert alert-info">
        <i class="fa fa-warning fa-fw fa-2x"></i><strong>Buzón Vacío!</strong> <br>
        No se encontraron procesos nuevos
    </p>
@endif

@php
    if(isset($idEstados))
    {
        $minprice = min($idEstados);
        $maxprice = max($idEstados);
    }
    else
    {
        $minprice = 0;
        $maxprice = 0;
    }
@endphp
<input type="hidden" value="0" id="minidEstadoEtapa2">
<input type="hidden" value="{{$minprice}}" id="minidEstadoEtapa">
<input type="hidden" value="{{$maxprice}}" id="maxidEstadoEtapa">

<script type="text/javascript">
//Gets tooltips activated
$("#inbox-table [rel=tooltip]").tooltip();

$("#inbox-table input[type='checkbox']").change(function() {
    $(this).closest('tr').toggleClass("highlight", this.checked);
});

$("#inbox-table .fila").click(function() {
    $this = $(this);
    getMail($this);
})

function getMail($this) {
    var remover = $("#remover").val();

    //console.log($this.closest("tr").attr("id"));
    //loadURL("ajax/email-opened.html", $('#inbox-content > .table-wrap'));
    var base_url = $('meta[name="base_url"]').attr('content'); 

    var id = $this.closest("tr").attr("id");

    var res = id.split("-");
    var idEstadoEtapa = res[0];
    var idTipoProceso = res[1];
    var tipoEstado = res[2];

    if(remover == 0)//cuando dan clic en remover actuación del buzón no entra a las rutas
    {
        if(tipoEstado == 2)// estado de reparto
        {
            var rutaRedirect = base_url +'/'+ 'reparto/index'; 
            /* es el id del tr el cual contiene el idEstadoEtapa */
            window.location.href = rutaRedirect+"/"+idEstadoEtapa;
            /* es el id del tr el cual contiene el idEstadoEtapa */
        }
        else
        {
            if(idTipoProceso == 1)// proceso judicial
            {
                var ruta = 'actuacionProc-judi'
                var rutaRedirect = base_url +'/'+ ruta+'/index'; 
                /* es el id del tr el cual contiene el idEstadoEtapa */
                window.location.href = rutaRedirect+"/"+idEstadoEtapa;
                /* es el id del tr el cual contiene el idEstadoEtapa */   
            }
            else if(idTipoProceso == 2)// conciliación prejudicial
            {
                var ruta = 'actuacionConci-prej'
                var rutaRedirect = base_url +'/'+ ruta+'/index'; 
                /* es el id del tr el cual contiene el idEstadoEtapa */
                window.location.href = rutaRedirect+"/"+idEstadoEtapa;
                /* es el id del tr el cual contiene el idEstadoEtapa */   
            }
            else if(idTipoProceso == 3)// tutelas
            {
                var ruta = 'actuacionTutelas'
                var rutaRedirect = base_url +'/'+ ruta+'/index'; 
                /* es el id del tr el cual contiene el idEstadoEtapa */
                window.location.href = rutaRedirect+"/"+idEstadoEtapa;
                /* es el id del tr el cual contiene el idEstadoEtapa */   
            }
        }
    }
}

$('.inbox-table-icon input:checkbox').click(function() {
    enableDeleteButton();
})

$(".deletebutton").click(function() {
    $('#inbox-table td input:checkbox:checked').parents("tr").rowslide();
    //$(".inbox-checkbox-triggered").removeClass('visible');
    //$("#compose-mail").show();
});

function enableDeleteButton() {
    var isChecked = $('.inbox-table-icon input:checkbox').is(':checked');

    if (isChecked) {
        $(".inbox-checkbox-triggered").addClass('visible');
        //$("#compose-mail").hide();
    } else {
        $(".inbox-checkbox-triggered").removeClass('visible');
        //$("#compose-mail").show();
    }
}
</script>