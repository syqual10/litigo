@extends('layouts.master')
@section('contenido')
  <!-- RIBBON -->
  <div id="ribbon">
    <span class="ribbon-button-alignment">
      <a href="{{ asset('home') }}">
        <span id="refresh" class="btn btn-ribbon" rel="tooltip" data-placement="bottom" data-original-title="Ir al inicio" data-html="true">
          <i class="fa fa-home"></i>
        </span>
      </a>
    </span>
    <!-- breadcrumb -->
    <ol class="breadcrumb">
      <li>Inicio</li><li>Demandas</li><li>Radicación</li>
    </ol>
    <!-- end breadcrumb -->
  </div>
  <!-- END RIBBON -->

  <!-- MAIN CONTENT -->
  <div id="content">
    <!-- widget grid -->
    <section id="widget-grid" class="">
      <!-- row -->
      <div class="row">
        <!-- NEW WIDGET START -->
        <article class="col-sm-12">
          <div class="jarviswidget jarviswidget-color-blue" role="widget">
            <header role="heading">
              <h2>Módulo <strong><i>de radicación</i></strong></h2>
            </header>
            <!-- widget div-->
            <div role="content" style="min-height:340px">
              <!-- widget content -->
              <div class="widget-body">
                <br><br>
                <div class="row">
                  @if(count($tiposProceso) > 0)
                    @foreach($tiposProceso as $tipoProceso)
                      <div class="col-sm-6 col-md-6 col-lg-4">
                        <a href="{{ asset($tipoProceso->rutaProceso.'/index/'.$tipoProceso->idTipoProcesos) }}">
                          <div class="product-content product-wrap clearfix">
                            <div class="row">
                              <div class="col-md-5 col-sm-12 col-xs-12">
                                <div class="product-image">
                                  <img src="{{asset('img/'.$tipoProceso->imgTipoProceso.'.png')}}" alt="194x228" class="img-responsive">
                                </div>
                              </div>
                              <div class="col-md-7 col-sm-12 col-xs-12">
                                <div class="product-deatil">
                                  <p class="price-container">
                                    <span>Radicar {{$tipoProceso->nombreTipoProceso}}</span>
                                  </p>
                                  <h5 class="name">
                                    <a href="#">
                                      Defensa Judicial <span>Módulo de Demandas</span>
                                    </a>
                                  </h5>
                                  <span class="tag1"></span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </a>
                      </div>
                    @endforeach
                  @endif

                  <!-- Buscar una Demanda
                  <a href=" asset('demandas/radicar')">
                    <div class="col-sm-6 col-md-6 col-lg-4" style="margin-top:22px">
                      <div class="product-content product-wrap clearfix">
                        <div class="row">
                          <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="product-image">
                              <img src="{asset('img/bus-dem.png')" alt="194x228" class="img-responsive">
                            </div>
                          </div>
                          <div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="product-deatil">
                              <p class="price-container">
                                <span>Búsqueda de Procesos</span>
                              </p>
                              <h5 class="name">
                                <a href="#">
                                  Defensa Judicial <span>Módulo de Demandas</span>
                                </a>
                              </h5>
                              <span class="tag1"></span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </a>
                   #Buscar una Demanda -->
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
  </div>
  <!-- END MAIN CONTENT -->
@endsection
