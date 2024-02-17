@php
  use SQ10\helpers\Util as Util;
@endphp
<!-- widget grid -->
<section id="widget-grid" class="">
  <!-- row -->
  <div class="row">
    <!-- NEW WIDGET START -->
    <article class="col-sm-12">
      <div class="jarviswidget jarviswidget-color-darken" role="widget">
        <header role="heading">
          @if(count($procesosAbogado) > 0)
            <h2>Mis procesos en: <strong><i>{{$procesosAbogado[0]->nombreTipoProceso}}</i></strong></h2>
          @else
            <h2>No se encontraron procesos</h2>
          @endif
          <a href="javascript:void(0)" onclick="consolidado({{$idResponsable}})" class="btn btn-sm btn-success pull-right">
            <i class="glyphicon glyphicon-chevron-left"></i> Volver atrás
          </a>
        </header>
        <!-- widget div-->
        <div role="content">
          <!-- widget content -->
          <div class="widget-body">
            <div class="logo-container full-screen-table-demo">
              <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
            </div>
            <div class="fresh-table full-screen-table toolbar-color-blue">              
              <table id="fresh-table" class="table tabla-fresh">
                <thead>
                  <tr>
                    <th data-sortable="true">Radicado Interno litígo</th>
                    <th data-sortable="true">Fecha Radicado</th>
                    <!--
                    <th data-sortable="true">Estado del Radicado</th>
                    -->
                    <th data-sortable="true">Tema</th>
                    <th data-sortable="true">Juzgado</th>
                    <th data-sortable="true">Personas</th>
                  </tr>
                </thead>
                  <tbody>
                    @if(count($procesosAbogado) > 0)
                      @php
                        $index = 0;
                      @endphp
                      @foreach($procesosAbogado as $procesoAbogado)
                        <tr>
                          @php
                            if($procesoAbogado->idTipoProcesos == 1)
                            {
                              $ruta = 'actuacionProc-judi/index/';
                            }
                            else if($procesoAbogado->idTipoProcesos == 2)
                            {
                              $ruta = 'actuacionConci-prej/index/';
                            }
                            else if($procesoAbogado->idTipoProcesos == 3)
                            {
                              $ruta = 'actuacionTutelas/index/';
                            }
                          @endphp
                          <td width="12%">
                            <a href="{{asset($ruta.$procesoAbogado->idEstadoEtapa)}}" style="color:#000">
                              <strong>{{$procesoAbogado->idRadicado."-".$procesoAbogado->vigenciaRadicado}}</strong>
                            </a>
                          </td>
                          <td width="12%">{{ucfirst(utf8_encode(strftime("%d de %B de %Y", strtotime($procesoAbogado->fechaRadicado))))}} {{ date('h:i A', strtotime($procesoAbogado->fechaRadicado))}}</td>
                          <!--
                          <td width="12%">
                            $arrayActuaciones[$index]['nombreActuacion']}}
                          </td>
                          -->
                          <td width="12%">{{$procesoAbogado->nombreTema}}</td>
                          <td width="12%">{{$procesoAbogado->nombreJuzgado}}</td>
                          <td width="12%">
                            {{$arrayDemandantes[$index]['demandantes']}}
                          </td>
                        </tr>
                        @php
                          $index++;
                        @endphp
                      @endforeach
                    @endif
                  </tbody>
              </table>
            </div>
          </div>
          <!-- end widget content -->
        </div>
        <!-- end widget div -->
      </div>
      <!-- end widget -->
    </article>
    <!-- WIDGET END -->
  </div>
<!-- end row -->
</section>
<!-- end widget grid -->