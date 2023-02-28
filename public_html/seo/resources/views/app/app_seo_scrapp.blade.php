@extends('layouts.bs5.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Analiysis de SEO</div>

                <div class="card-body">
                    <div class="row">
                        
                    
                        <div class="col-md-12">
                             {!! BootForm::open()->get()->inline()!!}
                 @if(isset($_GET['url']))
                     {!! BootForm::text('URL del Sitio Web','url')->value($_GET['url']) !!}
                 @else
                      {!! BootForm::text('URL del Sitio Web','url') !!}
                  @endif
                
               
                   {!! BootForm::submit('Consultar')->addClass('btn btn-success') !!}
                   {!! BootForm::close() !!}
                        </div>
                    </div>
                    
                     <div class="row">
                        <div class="col-md-12">
                              <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <h3 >SEO B&acutel;sico</h3>
                        </div>
                    </div>
                             @if(isset($title))
                            <div class="row">

                                 @if(!is_null($title))
                                
                                 
                                <div class="col-md-3"><b>Title</b></div>
                                <div class="col-md-9">
                                   {!! $title !!}
                                </div>
                                @endif
                            </div>
                            @endif
                            @if(isset($metas))
                            @foreach($metas as $meta)
                            <div class="row">
                                @if(!is_null($meta['name']))
                               
                                 
                                          <div class="col-md-3" class=""><b>{!! $meta['name'] !!}</b></div>
                                         <div class="col-md-9">{!! $meta['content'] !!}</div>
                                   
                          
                                @else
                                   
                                    <div class="col-md-3"><b>{!! $meta['property'] !!}</b></div>
                                <div class="col-md-9">{!! $meta['content'] !!}</div>
                                    
                                @endif

                                
                            </div>
                            @endforeach
                              <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <h3 >GZIP</h3>
                        </div>
                    </div>
                            @endif
                            @if(isset($gzip))
                            <div class="row">

                                 @if(!is_null($gzip))
                                
                                 
                                <div class="col-md-3"><b>GZip</b></div>
                                <div class="col-md-9">
                                    @if($gzip==1)
                                       Excelente usas una Coneccion Comprimida 
                                    @else
                                        Lamentable, becesitas comprimir la respuesta
                                    @endif
                                </div>
                                @endif
                            </div>
                            @endif
                              <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <h3 >ROBOTS</h3>
                        </div>
                    </div>
                             @if(isset($robots))
                            <div class="row">
                                 @if(!is_null($robots))
                                  
                                <div class="col-md-3"><b>Robots</b></div>
                                <div class="col-md-9">
                                    @if($robots==1)
                                       Excelente usas Robots.txt para rastreo 
                                    @else
                                       Lamentable, necesitas tener Robots.txt para rastreo
                                    @endif
                                </div>
                                @endif
                            </div>
                            @endif
                             @if(isset($sitemap))
                            <div class="row">
                                 @if(!is_null($sitemap))
                                  
                                <div class="col-md-3"><b>Sitemap</b></div>
                                <div class="col-md-9">

                                    @if($sitemap==1)
                                       Excelente usas Sitemap.xml  para rastreo 
                                    @else
                                       Grave necesitas tener Sitemap.xml para rastreo
                                    @endif
                                </div>
                                @endif
                            </div>
                            @endif
                            @if(isset($jsonLd))
                            <div class="row">
                                 @if(!is_null($jsonLd))
                                 
                                <div class="col-md-3"><b>Ld+Json</b></div>
                                <div class="col-md-9">
                                    @if(count($jsonLd)>0)
                                        
                                        @foreach($jsonLd as $n)
                                            {!! $n['content'] !!}
                                        @endforeach
                                    @else
                                        Datos Estructurados son las ultimas tendencia que google toma para ejercvetr influencia en el 
                                        SERP                                            
                                    @endif
                                    
                                </div>
                                @else
                                 
                                <div class="col-md-3">Ld+Json</div>
                                <div class="col-md-9">
                                    dedad
                                </div>
                                @endif
                            </div>
                            @endif
                          

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <h3 >SERP</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @if(isset($serp))
                                <div class="flex-center position-ref full-height">
              @foreach($serp as $res)
             <!--RESULT # -->
    <div class="result">
      <!--RESULT TITLE -->
      <h3 class="result-title">
        <a href="{!! $res->link !!}">{!! $res->title !!}</a>
      </h3>
      <!-- RESULT WEB ADDRESS (META) -->
      <div> 
        <cite class="meta-web-address">{!! $res->displayLink !!}</cite>
        <div class="action-menu-web-address">
          <a href="{!! $res->link !!}">
            <i class="fa fa-caret-down" aria-hidden="true"></i>
          </a>
        </div>
      </div>
      <!-- META DATE + DESCRIPTION -->
      <div class="meta-description">
        
        {!! $res->htmlSnippet !!}
      </div>
    </div>
    <!---->
    @endforeach
        </div>
                        </div>
                        @endif
                     </div>

                   		
                   				
                   		
                   		
                </div>
            </div>
        </div>
    </div>

@endsection
