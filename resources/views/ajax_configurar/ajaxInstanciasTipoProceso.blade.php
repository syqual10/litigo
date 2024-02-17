<div class="row"> 
    <br>
    @if(count($instancias) > 0)
        @foreach($instancias as $instancia)
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="alert alert-info fade in">         
                    <i class="fa-fw fa fa-info"></i>
                    <a href="#" onclick="editarInstancia({{$instancia->idInstancia}})"><strong>{{$instancia->nombreInstancia}}</strong></a>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-sm-12">
            <p class="alert alert-info">
                <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong> 
                No se encontraron instancias.
            </p>
        </div>
    @endif
</div>
