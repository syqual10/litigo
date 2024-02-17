<div class="form-wrap">
    <div class="form-group">
        <div class="col-sm-3">
            <label class="control-label pull-right">{{$input}}:</label>
        </div>
        <div class="col-sm-6">
        <select data-placeholder="Seleccionar Ciudad" class="form-control" id="{{$input}}" name="{{$input}}">
            <option value="">Seleccione {{$input}}</option>
            @php 
                $ciudades = DB::table('ciudades')
                    ->where('departamentos_idDepartamento', '=', $departamento)
                    ->get();
            @endphp
            @foreach ($ciudades as $ciudad)
                @if($valor == $ciudad->nombreCiudad)
                    <option value="{{$ciudad->nombreCiudad}}" selected>{{$ciudad->nombreCiudad}}</option>
                @else
                    <option value="{{$ciudad->nombreCiudad}}">{{$ciudad->nombreCiudad}}</option>
                @endif
            @endforeach  
        </select>
        </div>
    </div>
</div>