@if(count($demandantes) > 0)
    <h3>Asociar Demandantes</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Documento</th>
                <th>Nombre</th>
                <th></th>
            </tr>
        </thead>
        @foreach ($demandantes as $demandante)
            <tbody>
            
                <tr>
                    <td scope="row"> {{ $demandante->documentoSolicitante }} </td>
                    <td> {{ $demandante->nombreSolicitante }} </td>
                    <td>  
                        <div id="{{$demandante->idSolicitante}}" >
                            <button 
                                type="button" 
                                id="trasladarAccionante" 
                                onclick="trasladarAccionante({{ $demandante->idSolicitante }}, {{ $idRadicado }}, {{ $vigenciaRadicado }} )"  
                                class="btn btn-primary btn-sm btn-block"
                            >
                                TRASLADAR
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td scope="row"></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        @endforeach
    </table>
@else
    <p class="alert alert-info">
        <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong>
        No se encontraron demandantes para asociar.
    </p>
@endif