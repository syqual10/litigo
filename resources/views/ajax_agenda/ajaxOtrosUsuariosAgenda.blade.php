<div class="row">
    <div class="col-sm-12">
        <select data-placeholder="Seleccionar.." style="width:300px;" class="chosen-select" tabindex="8" id="usuariosNotificar" name="usuariosNotificar" multiple>
            <option value=""></option>
            @if(count($dependencias) > 0)
                @foreach ($dependencias as $dep)
                    <optgroup label="{{$dep->nombreDependencia}}">
                        @php
                            $usuarios = DB::table('usuarios')
                                        ->where('activoUsuario', '=', 1)
                                        ->where('dependencias_idDependencia', '=', $dep->idDependencia)
                                        ->get();
                        @endphp
                        @foreach ($usuarios as $usuario)
                            <option value="{{$usuario->idUsuario}}">{{$usuario->nombresUsuario}}</option> 
                        @endforeach              
                    </optgroup>              
                @endforeach 
            @else
                No hay dependencias
            @endif   
        </select>
    </div>
</div>