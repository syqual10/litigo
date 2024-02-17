<div class="row">
    <div class="col-sm-6">
        <div class="alert alert-info fade in">         
            <i class="fa-fw fa fa-info"></i>
            <a href="#" onclick="agregarResponsable({{$etapaRadicacion[0]->idEtapa}})"><strong>Rad</strong></a>
        </div>
    </div>

    <div class="col-sm-5">
        <a href="javascript:void(0);" class="btn btn-default shop-btn">
            <i class="fa fa-2x fa-users"></i>
            <span class="air air-top-right label-danger txt-color-white padding-5">{{$responsablesRadicacion}}</span>
        </a>
    </div>
</div>

@if(count($etapasProceso) > 0)    
    @foreach($etapasProceso as $etapaProceso)
        <div class="row">
            <div class="col-sm-6">            
                <div class="alert alert-info fade in">         
                    <i class="fa-fw fa fa-info"></i>
                    <a href="#" onclick="agregarResponsable({{$etapaProceso->idEtapa}})"><strong>{{$etapaProceso->nombreEtapa}}</strong></a>
                </div>
            </div>

            @php
                $responsablesEtapa = DB::table('juriresponsablesetapas')
                    ->where('jurietapas_idEtapa', '=', $etapaProceso->idEtapa)
                    ->count();
            @endphp
            <div class="col-sm-5">
                <a href="javascript:void(0);" class="btn btn-default shop-btn">
                    <i class="fa fa-2x fa-users"></i>
                    <span class="air air-top-right label-danger txt-color-white padding-5">{{$responsablesEtapa}}</span>
                </a>
            </div>
        </div>
    @endforeach    
@endif